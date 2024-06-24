<?php

namespace App\Livewire\Projects;

use App\Helpers\DataTypeConverter;
use App\Models\Position;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class PositionSelection extends Component
{
    public $positions = [];
    public $selectedPositions = [];
    public $quantities = [];
    public $requiredDays = [];
    public $efficiencyInputs = [];
    public $efficiencies = [];
    public $partialCosts = [];
    public $totalLaborCost = 0;

    public $isEdit = false;
    public $existingSelections = []; // Datos existentes en modo edición

    protected $rules = [
        'selectedPositions' => 'required|array|min:1',
        'selectedPositions.*' => 'exists:positions,id',
        'quantities.*' => 'nullable|numeric|min:0',
        'requiredDays.*' => 'nullable|numeric|min:0',
        'efficiencyInputs.*' => 'nullable|string',
    ];

    public function mount(): void
    {
        $this->positions = Position::all();
        if ($this->isEdit) {
            $this->initializeFromExistingSelections();
        }
        $this->updateTotalLaborCost();
    }

    public function initializeFromExistingSelections(): void
    {
        foreach ($this->existingSelections as $selection) {
            $positionId = $selection['position_id'];
            $this->selectedPositions[] = $positionId;
            $this->quantities[$positionId] = $selection['quantity'];
            $this->requiredDays[$positionId] = $selection['required_days'];
            $this->efficiencyInputs[$positionId] = $selection['efficiency'];
            $this->efficiencies[$positionId] = DataTypeConverter::convertToFloat($selection['efficiency']);
            $this->calculatePartialCost($positionId);
        }
    }

    public function calculatePartialCost($positionId): void
    {
        if (in_array($positionId, $this->selectedPositions)) {
            $quantity = $this->quantities[$positionId] ?? 0;
            $requiredDays = $this->requiredDays[$positionId] ?? 0;
            $efficiencyInput = $this->efficiencyInputs[$positionId] ?? "1";
            $efficiency = DataTypeConverter::convertToFloat($efficiencyInput);

            if ($efficiency === null) {
                $this->partialCosts[$positionId] = 0;
                $this->addError('efficiencyInput', "Entrada de rendimiento inválida: '$efficiencyInput'");
            } else {
                $position = Position::find($positionId);
                $dailyCost = $position->real_daily_cost;
                $this->partialCosts[$positionId] = $quantity * $requiredDays * $efficiency * $dailyCost;
            }
        } else {
            $this->partialCosts[$positionId] = 0;
        }
    }

    public function updatedQuantities($value, $positionId): void
    {
        if (!is_numeric($value)) {
            $this->quantities[$positionId] = null;
            return;
        }
        $this->calculatePartialCost($positionId);
        $this->updateTotalLaborCost();
    }

    public function updatedRequiredDays($value, $positionId): void
    {
        if (!is_numeric($value)) {
            $this->requiredDays[$positionId] = null;
            return;
        }
        $this->calculatePartialCost($positionId);
        $this->updateTotalLaborCost();
    }

    public function updatedEfficiencyInputs($value, $positionId): void
    {
        $efficiency = DataTypeConverter::convertToFloat($value);
        if ($efficiency === null) {
            $this->addError('efficiencyInput', "Entrada de rendimiento inválida: '$value'");
            return;
        }
        $this->efficiencies[$positionId] = $efficiency;
        $this->efficiencyInputs[$positionId] = $value;
        $this->calculatePartialCost($positionId);
        $this->updateTotalLaborCost();
    }

    public function updateTotalLaborCost(): void
    {
        $this->totalLaborCost = array_sum($this->partialCosts);
    }

    public function sendTotalLaborCost(): void
    {
        $this->dispatch('totalLaborCostUpdated', $this->totalLaborCost);
        $this->dispatch('positionSelectionUpdated', [
            'selectedPositions' => $this->selectedPositions,
            'positionQuantities' => $this->quantities,
            'positionRequiredDays' => $this->requiredDays,
            'positionEfficiencies' => $this->efficiencies,
            'totalLaborCost' => $this->totalLaborCost,
        ]);

        if ($this->totalLaborCost > 0) {
            $this->dispatch('hideResourceForm');
        }
    }

    public function render(): View
    {
        return view('livewire.projects.position-selection', [
            'positions' => $this->positions,
        ]);
    }
}
