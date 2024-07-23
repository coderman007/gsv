<?php

namespace App\Livewire\Projects;

use App\Helpers\DataTypeConverter;
use App\Models\Position;
use Illuminate\View\View;
use Livewire\Component;

class PositionSelectionCreate extends Component
{
    public $availablePositionsCreate = [];
    public $selectedPositionsCreate = [];
    public $expandedPositionsCreate = [];
    public $quantitiesCreate = [];
    public $requiredDaysCreate = [];
    public $efficiencyInputsCreate = [];
    public $efficienciesCreate = [];
    public $partialCostsCreate = [];
    public $totalLaborCostCreate = 0;

    protected $rules = [
        'quantitiesCreate.*' => 'nullable|numeric|min:0',
        'requiredDaysCreate.*' => 'nullable|numeric|min:0',
        'efficiencyInputsCreate.*' => 'nullable|string',
    ];

    public function mount(): void
    {
        $this->availablePositionsCreate = Position::all();
        $this->updateTotalLaborCostCreate();
    }

    public function toggleExpand($positionId): void
    {
        if (in_array($positionId, $this->expandedPositionsCreate)) {
            // Remove from expanded list
            $this->expandedPositionsCreate = array_diff($this->expandedPositionsCreate, [$positionId]);

            // Clear data
            unset($this->quantitiesCreate[$positionId]);
            unset($this->requiredDaysCreate[$positionId]);
            unset($this->efficiencyInputsCreate[$positionId]);
            unset($this->efficienciesCreate[$positionId]);
            unset($this->partialCostsCreate[$positionId]);

            // Remove from selected list
            $this->selectedPositionsCreate = array_diff($this->selectedPositionsCreate, [$positionId]);
        } else {
            $this->expandedPositionsCreate[] = $positionId;
        }

        // Update total cost
        $this->updateTotalLaborCostCreate();
    }

    public function calculatePartialCostCreate($positionId): void
    {
        if (in_array($positionId, $this->expandedPositionsCreate)) {
            $quantity = $this->quantitiesCreate[$positionId] ?? 0;
            $requiredDays = $this->requiredDaysCreate[$positionId] ?? 0;
            $efficiencyInput = $this->efficiencyInputsCreate[$positionId] ?? "1";
            $efficiency = DataTypeConverter::convertToFloat($efficiencyInput);

            if ($efficiency === null) {
                $this->partialCostsCreate[$positionId] = 0;
                $this->addError("efficiencyInputsCreate_$positionId", "Entrada de rendimiento inválida: '$efficiencyInput'");
            } else {
                $position = Position::find($positionId);
                $dailyCost = $position->real_daily_cost;
                $this->partialCostsCreate[$positionId] = $quantity * $requiredDays * $efficiency * $dailyCost;
                $this->selectedPositionsCreate[] = $positionId;
            }
        } else {
            $this->partialCostsCreate[$positionId] = 0;
        }

        $this->updateTotalLaborCostCreate();
    }

    public function updatedQuantitiesCreate($value, $positionId): void
    {
        if (!is_numeric($value)) {
            $this->quantitiesCreate[$positionId] = null;
            return;
        }
        $this->calculatePartialCostCreate($positionId);
    }

    public function updatedRequiredDaysCreate($value, $positionId): void
    {
        if (!is_numeric($value)) {
            $this->requiredDaysCreate[$positionId] = null;
            return;
        }
        $this->calculatePartialCostCreate($positionId);
    }

    public function updatedEfficiencyInputsCreate($value, $positionId): void
    {
        $efficiency = DataTypeConverter::convertToFloat($value);

        if ($efficiency === null) {
            $this->addError("efficiencyInputsCreate_$positionId", "Entrada de rendimiento inválida: '$value'");
            return;
        }
        $this->efficienciesCreate[$positionId] = $efficiency;
        $this->efficiencyInputsCreate[$positionId] = $value;
        $this->calculatePartialCostCreate($positionId);
    }

    public function updateTotalLaborCostCreate(): void
    {
        $this->totalLaborCostCreate = array_sum($this->partialCostsCreate);
    }

    public function sendTotalLaborCostCreate(): void
    {
        $this->dispatch('positionSelectionCreateUpdated', [
            'selectedPositionsCreate' => $this->selectedPositionsCreate,
            'positionQuantitiesCreate' => $this->quantitiesCreate,
            'positionRequiredDaysCreate' => $this->requiredDaysCreate,
            'positionEfficienciesCreate' => $this->efficienciesCreate,
            'totalLaborCostCreate' => $this->totalLaborCostCreate,
        ]);

        if ($this->totalLaborCostCreate > 0) {
            $this->dispatch('hideResourceFormCreate');
        }
    }

    public function render(): View
    {
        return view('livewire.projects.position-selection-create', [
            'positions' => $this->availablePositionsCreate,
        ]);
    }
}


<div class="bg-gray-50 p-6 rounded-lg">
    <label class="text-lg font-semibold text-gray-600 py-2">
        <h3 class="mb-2">Mano de Obra</h3>
        <div class="mb-4 grid grid-cols-1 gap-4">
@foreach ($positions as $position)
    <div class="flex items-center justify-between">
        <div class="flex items-center">
            @if (in_array($position->id, $expandedPositionsCreate))
                <button wire:click="toggleExpand({{ $position->id }})" class="text-red-500">-</button>
            @else
                <button wire:click="toggleExpand({{ $position->id }})" class="text-green-500">+</button>
            @endif
            <span class="ml-2 text-sm font-medium text-gray-700">{{ $position->name }}</span>
        </div>
    </div>

    @if (in_array($position->id, $expandedPositionsCreate))
        <div class="ml-6 grid grid-cols-4 gap-4 mt-2">
            <div>
                <label for="quantityCreate{{ $position->id }}" class="block text-sm font-medium text-gray-700">Cantidad</label>
                <input wire:model.live="quantitiesCreate.{{ $position->id }}" type="number" min=0 step=1
                       id="quantityCreate{{ $position->id }}" name="quantityCreate{{ $position->id }}"
                       class="mt-1 p-2 block w-full border-teal-300 rounded-md focus:ring-teal-500 focus:border-teal-500">

                @error('quantitiesCreate.' . $position->id)
                <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="requiredDaysCreate{{ $position->id }}" class="block text-sm font-medium text-gray-700">Días</label>
                <input wire:model.live="requiredDaysCreate.{{ $position->id }}" type="number" min=0 step=1
                       id="requiredDaysCreate{{ $position->id }}" name="requiredDaysCreate{{ $position->id }}"
                       class="mt-1 p-2 block w-full border-teal-300 rounded-md focus:ring-teal-500 focus:border-teal-500">

                @error('requiredDaysCreate.' . $position->id)
                <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="efficiencyCreate{{ $position->id }}" class="block text-sm font-medium text-gray-700">Rendimiento</label>
                <input wire:model.live="efficiencyInputsCreate.{{ $position->id }}" type="text"
                       id="efficiencyCreate{{ $position->id }}"
                       class="mt-1 p-2 block w-full border-teal-300 rounded-md focus:ring-teal-500 focus:border-teal-500">
            </div>
            @error("efficiencyInputsCreate.{{ $position->id }}")
            <span class="text-red-500">{{ $message }}</span>
            @enderror
            <div>
                <label for="partialCostCreate{{ $position->id }}" class="block text-sm font-medium text-gray-700">Costo Parcial</label>
                <input type="text" readonly
                       value="{{ isset($partialCostsCreate[$position->id]) ? number_format($partialCostsCreate[$position->id], 2) : 0 }}"
                       id="partialCostCreate{{ $position->id }}"
                       class="mt-1 p-2 block w-full border-teal-300 rounded-md bg-teal-100 focus:ring-teal-500 focus:border-teal-500">
            </div>
        </div>
        @endif
        @endforeach
        </div>
        <div class="flex items-center mt-4">
            <label for="totalLaborCostCreate" class="block text-lg font-medium mr-4 text-gray-700">Total Mano de Obra</label>
            <div class="relative rounded-md shadow-sm flex-1">
                <input type="text" readonly value="{{ number_format($totalLaborCostCreate, 2) }}" id="totalLaborCostCreate"
                       class="text-right mt-1 p-2 pl-10 block w-full border-teal-500 rounded-md bg-teal-100 focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
            </div>

            <div class="ml-4">
                <button wire:click="sendTotalLaborCostCreate" type="button"
                        class="bg-teal-500 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded-full">
                    Confirmar Mano de Obra
                </button>
            </div>
        </div>
        </label>
        </div>
