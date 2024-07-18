<?php

namespace App\Livewire\Projects;

use App\Helpers\DataTypeConverter;
use App\Models\Position;
use Illuminate\View\View;
use Livewire\Component;

class PositionSelectionEdit extends Component
{
    public $availablePositionsEdit = [];
    public $selectedPositionsEdit = [];
    public $quantitiesEdit = [];
    public $requiredDaysEdit = [];
    public $efficiencyInputsEdit = [];
    public $efficienciesEdit = [];
    public $partialCostsEdit = [];
    public $totalLaborCostEdit = 0;

    public $existingSelections = [];

    protected $rules = [
        'selectedPositionsEdit' => 'required|array|min:1',
        'selectedPositionsEdit.*' => 'exists:positions,id',
        'quantitiesEdit.*' => 'nullable|numeric|min:0',
        'requiredDaysEdit.*' => 'nullable|numeric|min:0',
        'efficiencyInputsEdit.*' => 'nullable|string',
    ];

    public function mount(): void
    {
        $this->availablePositionsEdit = Position::all();
        $this->initializeFromExistingSelections();
        $this->updateTotalLaborCostEdit();
    }

    public function initializeFromExistingSelections(): void
    {
        foreach ($this->existingSelections as $selection) {
            $positionId = $selection['position_id'];
            $this->selectedPositionsEdit[] = $positionId;
            $this->quantitiesEdit[$positionId] = $selection['quantity'];
            $this->requiredDaysEdit[$positionId] = $selection['required_days'];
            $this->efficiencyInputsEdit[$positionId] = $selection['efficiency'];
            $this->efficienciesEdit[$positionId] = DataTypeConverter::convertToFloat($selection['efficiency']);
            $this->calculatePartialCostEdit($positionId);
        }
    }

    public function updatedSelectedPositionsEdit(): void
    {
        foreach ($this->availablePositionsEdit as $position) {
            $positionId = $position->id;
            if (!in_array($positionId, $this->selectedPositionsEdit)) {
                $this->quantitiesEdit[$positionId] = null;
                $this->requiredDaysEdit[$positionId] = null;
                $this->efficiencyInputsEdit[$positionId] = null;
                $this->efficienciesEdit[$positionId] = null;
                $this->partialCostsEdit[$positionId] = 0;
            }
        }
        $this->updateTotalLaborCostEdit();
    }

    public function calculatePartialCostEdit($positionId): void
    {
        if (in_array($positionId, $this->selectedPositionsEdit)) {
            $quantity = $this->quantitiesEdit[$positionId] ?? 0;
            $requiredDays = $this->requiredDaysEdit[$positionId] ?? 0;
            $efficiencyInput = $this->efficiencyInputsEdit[$positionId] ?? "1";
            $efficiency = DataTypeConverter::convertToFloat($efficiencyInput);

            if ($efficiency === null) {
                $this->partialCostsEdit[$positionId] = 0;
                $this->addError('efficiencyInputsEdit', "Entrada de rendimiento inválida: '$efficiencyInput'");
            } else {
                $position = Position::find($positionId);
                $dailyCost = $position->real_daily_cost;
                $this->partialCostsEdit[$positionId] = $quantity * $requiredDays * $efficiency * $dailyCost;
            }
        } else {
            $this->partialCostsEdit[$positionId] = 0;
        }
    }

    public function updatedQuantitiesEdit($value, $positionId): void
    {
        if (!is_numeric($value)) {
            $this->quantitiesEdit[$positionId] = null;
            return;
        }
        $this->calculatePartialCostEdit($positionId);
        $this->updateTotalLaborCostEdit();
    }

    public function updatedRequiredDaysEdit($value, $positionId): void
    {
        if (!is_numeric($value)) {
            $this->requiredDaysEdit[$positionId] = null;
            return;
        }
        $this->calculatePartialCostEdit($positionId);
        $this->updateTotalLaborCostEdit();
    }

    public function updatedEfficiencyInputsEdit($value, $positionId): void
    {
        $efficiency = DataTypeConverter::convertToFloat($value);
        if ($efficiency === null) {
            $this->addError('efficiencyInputsEdit', "Entrada de rendimiento inválida: '$value'");
            return;
        }
        $this->efficienciesEdit[$positionId] = $efficiency;
        $this->efficiencyInputsEdit[$positionId] = $value;
        $this->calculatePartialCostEdit($positionId);
        $this->updateTotalLaborCostEdit();
    }

    public function updateTotalLaborCostEdit(): void
    {
        $this->totalLaborCostEdit = array_sum($this->partialCostsEdit);
    }

    public function sendTotalLaborCostEdit(): void
    {
//        $this->dispatch('totalLaborCostEditUpdated', $this->totalLaborCostEdit);
        $this->dispatch('positionSelectionEditUpdated', [
            'selectedPositionsEdit' => $this->selectedPositionsEdit,
            'positionQuantitiesEdit' => $this->quantitiesEdit,
            'positionRequiredDaysEdit' => $this->requiredDaysEdit,
            'positionEfficienciesEdit' => $this->efficienciesEdit,
            'totalLaborCostEdit' => $this->totalLaborCostEdit,
        ]);

        if ($this->totalLaborCostEdit > 0) {
            $this->dispatch('hideResourceFormEdit');
        }
    }

    public function render(): View
    {
        return view('livewire.projects.position-selection-edit', [
            'positions' => $this->availablePositionsEdit,
        ]);
    }
}
