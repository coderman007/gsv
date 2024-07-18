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
        'selectedPositionsCreate' => 'required|array|min:1',
        'selectedPositionsCreate.*' => 'exists:positions,id',
        'quantitiesCreate.*' => 'nullable|numeric|min:0',
        'requiredDaysCreate.*' => 'nullable|numeric|min:0',
        'efficiencyInputsCreate.*' => 'nullable|string',
    ];

    public function mount(): void
    {
        $this->availablePositionsCreate = Position::all();
        $this->updateTotalLaborCostCreate();
    }

    public function updatedSelectedPositionsCreate(): void
    {
        foreach ($this->availablePositionsCreate as $position) {
            $positionId = $position->id;
            if (!in_array($positionId, $this->selectedPositionsCreate)) {
                $this->quantitiesCreate[$positionId] = null;
                $this->requiredDaysCreate[$positionId] = null;
                $this->efficiencyInputsCreate[$positionId] = null;
                $this->efficienciesCreate[$positionId] = null;
                $this->partialCostsCreate[$positionId] = 0;
            }
        }
        $this->updateTotalLaborCostCreate();
    }

    public function calculatePartialCostCreate($positionId): void
    {
        if (in_array($positionId, $this->selectedPositionsCreate)) {
            $quantity = $this->quantitiesCreate[$positionId] ?? 0;
            $requiredDays = $this->requiredDaysCreate[$positionId] ?? 0;
            $efficiencyInput = $this->efficiencyInputsCreate[$positionId] ?? "1";
            $efficiency = DataTypeConverter::convertToFloat($efficiencyInput);

            if ($efficiency === null) {
                $this->partialCostsCreate[$positionId] = 0;
                $this->addError('efficiencyInputsCreate', "Entrada de rendimiento inválida: '$efficiencyInput'");
            } else {
                $position = Position::find($positionId);
                $dailyCost = $position->real_daily_cost;
                $this->partialCostsCreate[$positionId] = $quantity * $requiredDays * $efficiency * $dailyCost;
            }
        } else {
            $this->partialCostsCreate[$positionId] = 0;
        }
    }

    public function updatedQuantitiesCreate($value, $positionId): void
    {
        if (!is_numeric($value)) {
            $this->quantitiesCreate[$positionId] = null;
            return;
        }
        $this->calculatePartialCostCreate($positionId);
        $this->updateTotalLaborCostCreate();
    }

    public function updatedRequiredDaysCreate($value, $positionId): void
    {
        if (!is_numeric($value)) {
            $this->requiredDaysCreate[$positionId] = null;
            return;
        }
        $this->calculatePartialCostCreate($positionId);
        $this->updateTotalLaborCostCreate();
    }

    public function updatedEfficiencyInputsCreate($value, $positionId): void
    {
        $efficiency = DataTypeConverter::convertToFloat($value);
        if ($efficiency === null) {
            $this->addError('efficiencyInputsCreate', "Entrada de rendimiento inválida: '$value'");
            return;
        }
        $this->efficienciesCreate[$positionId] = $efficiency;
        $this->efficiencyInputsCreate[$positionId] = $value;
        $this->calculatePartialCostCreate($positionId);
        $this->updateTotalLaborCostCreate();
    }

    public function updateTotalLaborCostCreate(): void
    {
        $this->totalLaborCostCreate = array_sum($this->partialCostsCreate);
    }

    public function sendTotalLaborCostCreate(): void
    {
//        $this->dispatch('totalLaborCostCreateUpdated', $this->totalLaborCostCreate);
//        dd($this->totalLaborCostCreate);
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
