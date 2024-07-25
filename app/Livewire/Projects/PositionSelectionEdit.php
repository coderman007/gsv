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
    public $quantitiesPositionEdit = [];
    public $requiredDaysPositionEdit = [];
    public $efficiencyInputsPositionEdit = [];
    public $efficienciesPositionEdit = [];
    public $partialCostsPositionEdit = [];
    public $totalLaborCostEdit = 0;
    public $positionSearchEdit = '';
    public $existingSelections = [];

    protected $rules = [
        'selectedPositionsEdit' => 'required|array|min:1',
        'selectedPositionsEdit.*' => 'exists:positions,id',
        'quantitiesPositionEdit.*' => 'nullable|numeric|min:0',
        'requiredDaysPositionEdit.*' => 'nullable|numeric|min:0',
        'efficiencyInputsPositionEdit.*' => 'nullable|string',
    ];

    public function mount(): void
    {
        $this->initializeFromExistingSelections();
        $this->updateTotalLaborCostEdit();
    }

    public function initializeFromExistingSelections(): void
    {
        foreach ($this->existingSelections as $selection) {
            $positionId = $selection['position_id'];
            $this->selectedPositionsEdit[] = $positionId;
            $this->quantitiesPositionEdit[$positionId] = $selection['quantity'];
            $this->requiredDaysPositionEdit[$positionId] = $selection['required_days'];
            $this->efficiencyInputsPositionEdit[$positionId] = $selection['efficiency'];
            $this->efficienciesPositionEdit[$positionId] = DataTypeConverter::convertToFloat($selection['efficiency']);
            $this->calculatePartialCostPositionEdit($positionId);
        }
        $this->availablePositionsEdit = Position::whereIn('id', $this->selectedPositionsEdit)->get();
    }

    public function updatedSelectedPositionsEdit(): void
    {
        foreach ($this->availablePositionsEdit as $position) {
            $positionId = $position->id;
            if (!in_array($positionId, $this->selectedPositionsEdit)) {
                $this->quantitiesPositionEdit[$positionId] = null;
                $this->requiredDaysPositionEdit[$positionId] = null;
                $this->efficiencyInputsPositionEdit[$positionId] = null;
                $this->efficienciesPositionEdit[$positionId] = null;
                $this->partialCostsPositionEdit[$positionId] = 0;
            }
        }
        $this->updateTotalLaborCostEdit();
    }

    public function addPositionEdit($positionId): void
    {
        if (!in_array($positionId, $this->selectedPositionsEdit)) {
            $this->selectedPositionsEdit[] = $positionId;
        } else {
            // Move the position to the end of the array to ensure it is displayed last
            $this->selectedPositionsEdit = array_merge(array_diff($this->selectedPositionsEdit, [$positionId]), [$positionId]);
        }
        $this->positionSearchEdit = '';
        $this->updateTotalLaborCostEdit();
    }

    public function removePositionEdit($positionId): void
    {
        $this->selectedPositionsEdit = array_diff($this->selectedPositionsEdit, [$positionId]);
        unset($this->quantitiesPositionEdit[$positionId]);
        unset($this->requiredDaysPositionEdit[$positionId]);
        unset($this->efficiencyInputsPositionEdit[$positionId]);
        unset($this->efficienciesPositionEdit[$positionId]);
        unset($this->partialCostsPositionEdit[$positionId]);
        $this->updateTotalLaborCostEdit();
    }


    public function calculatePartialCostPositionEdit($positionId): void
    {
        $quantity = $this->quantitiesPositionEdit[$positionId] ?? 0;
        $requiredDays = $this->requiredDaysPositionEdit[$positionId] ?? 0;
        $efficiencyInput = $this->efficiencyInputsPositionEdit[$positionId] ?? "1";
        $efficiency = DataTypeConverter::convertToFloat($efficiencyInput);

        if ($efficiency === null) {
            $this->partialCostsPositionEdit[$positionId] = 0;
            $this->addError("efficiencyInputsPositionEdit_$positionId", "Entrada de rendimiento inválida: '$efficiencyInput'");
        } else {
            $position = Position::find($positionId);
            $unitPrice = $position->real_daily_cost;
            $this->partialCostsPositionEdit[$positionId] = $quantity * $requiredDays * $efficiency * $unitPrice;
        }

        $this->updateTotalLaborCostEdit();
    }

    public function updatedQuantitiesPositionEdit($value, $positionId): void
    {
        if (!is_numeric($value)) {
            $this->quantitiesPositionEdit[$positionId] = null;
            return;
        }
        $this->calculatePartialCostPositionEdit($positionId);
        $this->updateTotalLaborCostEdit();
    }

    public function updatedRequiredDaysPositionEdit($value, $positionId): void
    {
        if (!is_numeric($value)) {
            $this->requiredDaysPositionEdit[$positionId] = null;
            return;
        }
        $this->calculatePartialCostPositionEdit($positionId);
        $this->updateTotalLaborCostEdit();
    }

    public function updatedEfficiencyInputsPositionEdit($value, $positionId): void
    {
        $efficiency = DataTypeConverter::convertToFloat($value);
        if ($efficiency === null) {
            $this->addError('efficiencyInputsPositionEdit', "Entrada de rendimiento inválida: '$value'");
            return;
        }
        $this->efficienciesPositionEdit[$positionId] = $efficiency;
        $this->efficiencyInputsPositionEdit[$positionId] = $value;
        $this->calculatePartialCostPositionEdit($positionId);
        $this->updateTotalLaborCostEdit();
    }

    public function updateTotalLaborCostEdit(): void
    {
        $this->totalLaborCostEdit = array_sum($this->partialCostsPositionEdit);
    }

    public function sendTotalLaborCostEdit(): void
    {
//        $this->dispatch('totalLaborCostEditUpdated', $this->totalLaborCostEdit);
        $this->dispatch('positionSelectionEditUpdated', [
            'selectedPositionsEdit' => $this->selectedPositionsEdit,
            'positionQuantitiesEdit' => $this->quantitiesPositionEdit,
            'positionRequiredDaysEdit' => $this->requiredDaysPositionEdit,
            'positionEfficienciesEdit' => $this->efficienciesPositionEdit,
            'totalLaborCostEdit' => $this->totalLaborCostEdit,
        ]);

        if ($this->totalLaborCostEdit > 0) {
            $this->dispatch('hideResourceFormEdit');
        }
    }

    public function render(): View
    {
        $filteredPositions = Position::query()
            ->where('name', 'like', "%$this->positionSearchEdit%")
            ->get();

        // Reverse the selected positions array to show the last selected at the top
        $selectedPositions = Position::whereIn('id', $this->selectedPositionsEdit)->get()->sortByDesc(function ($position) {
            return array_search($position->id, $this->selectedPositionsEdit);
        });

        return view('livewire.projects.position-selection-edit', [
            'positions' => $filteredPositions,
            'selectedPositions' => $selectedPositions,
        ]);
    }
}
