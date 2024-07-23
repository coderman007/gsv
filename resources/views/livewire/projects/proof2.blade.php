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

    public function addPosition($positionId): void
    {
        if (!in_array($positionId, $this->selectedPositionsCreate)) {
            $this->selectedPositionsCreate[] = $positionId;
        }
        $this->updateTotalLaborCostCreate();
    }

    public function removePosition($positionId): void
    {
        $this->selectedPositionsCreate = array_diff($this->selectedPositionsCreate, [$positionId]);
        unset($this->quantitiesCreate[$positionId]);
        unset($this->requiredDaysCreate[$positionId]);
        unset($this->efficiencyInputsCreate[$positionId]);
        unset($this->efficienciesCreate[$positionId]);
        unset($this->partialCostsCreate[$positionId]);
        $this->updateTotalLaborCostCreate();
    }

    public function calculatePartialCostCreate($positionId): void
    {
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
        <div class="mb-4">
            <label for="positionSelect" class="block text-sm font-medium text-gray-700">Seleccionar Posiciones</label>
            <select id="positionSelect" class="mt-1 p-2 block w-full border-teal-300 rounded-md focus:ring-teal-500 focus:border-teal-500"
                    wire:change="addPosition($event.target.value)">
                <option value="">Seleccione una posición</option>
@foreach ($positions as $position)
    @if (!in_array($position->id, $selectedPositionsCreate))
        <option value="{{ $position->id }}">{{ $position->name }}</option>
        @endif
        @endforeach
        </select>
        </div>
        <div class="grid grid-cols-1 gap-4">
            @foreach ($selectedPositionsCreate as $positionId)
                @php
                    $position = $positions->find($positionId);
                @endphp
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <button wire:click="removePosition({{ $positionId }})" class="text-red-500">-</button>
                        <span class="ml-2 text-sm font-medium text-gray-700">{{ $position->name }}</span>
                    </div>
                </div>
                <div class="ml-6 grid grid-cols-4 gap-4 mt-2">
                    <div>
                        <label for="quantityCreate{{ $positionId }}" class="block text-sm font-medium text-gray-700">Cantidad</label>
                        <input wire:model.live="quantitiesCreate.{{ $positionId }}" type="number" min=0 step=1
                               id="quantityCreate{{ $positionId }}" name="quantityCreate{{ $positionId }}"
                               class="mt-1 p-2 block w-full border-teal-300 rounded-md focus:ring-teal-500 focus:border-teal-500">
                        @error('quantitiesCreate.' . $positionId)
                        <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="requiredDaysCreate{{ $positionId }}" class="block text-sm font-medium text-gray-700">Días</label>
                        <input wire:model.live="requiredDaysCreate.{{ $positionId }}" type="number" min=0 step=1
                               id="requiredDaysCreate{{ $positionId }}" name="requiredDaysCreate{{ $positionId }}"
                               class="mt-1 p-2 block w-full border-teal-300 rounded-md                    focus:ring-teal-500 focus:border-teal-500">
                        @error('requiredDaysCreate.' . $positionId)
                        <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="efficiencyCreate{{ $positionId }}" class="block text-sm font-medium text-gray-700">Eficiencia</label>
                        <input wire:model.live="efficiencyInputsCreate.{{ $positionId }}" type="text"
                               id="efficiencyCreate{{ $positionId }}" name="efficiencyCreate{{ $positionId }}"
                               class="mt-1 p-2 block w-full border-teal-300 rounded-md focus:ring-teal-500 focus:border-teal-500">
                        @error('efficiencyInputsCreate.' . $positionId)
                        <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="partialCostCreate{{ $positionId }}" class="block text-sm font-medium text-gray-700">Costo Parcial</label>
                        <input type="text" id="partialCostCreate{{ $positionId }}" name="partialCostCreate{{ $positionId }}"
                               value="{{ $partialCostsCreate[$positionId] ?? 0 }}" readonly
                               class="mt-1 p-2 block w-full bg-gray-100 border-teal-300 rounded-md focus:ring-teal-500 focus:border-teal-500">
                    </div>
                </div>
            @endforeach
        </div>
        </label>
        <div class="mt-6">
            <label for="totalLaborCostCreate" class="block text-lg font-semibold text-gray-600">Costo Total de Mano de Obra</label>
            <input type="text" id="totalLaborCostCreate" name="totalLaborCostCreate" value="{{ $totalLaborCostCreate }}" readonly
                   class="mt-1 p-2 block w-full bg-gray-100 border-teal-300 rounded-md focus:ring-teal-500 focus:border-teal-500">
        </div>
        <div class="mt-4 flex justify-end">
            <button wire:click="sendTotalLaborCostCreate" class="bg-teal-500 text-white px-4 py-2 rounded-md hover:bg-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                Guardar
            </button>
        </div>
        </div>
