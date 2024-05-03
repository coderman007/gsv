<?php

namespace App\Livewire\Projects;

use App\Helpers\DataTypeConverter;
use App\Models\Position;
use Illuminate\View\View;
use Livewire\Component;

class PositionSelection extends Component
{
    public $positions = [];
    public $selectedPositions = [];
    public $quantities = [];
    public $requiredDays = [];
    public $efficiencies = [];
    public $partialCosts = [];
    public $totalLaborCost = 0;
    public $formattedTotalLaborCost;

    protected $rules = [
        'selectedPositions' => 'required|array|min:1',
        'selectedPositions.*' => 'exists:positions,id',
        'quantities.*' => 'nullable|numeric|min:0',
        'requiredDays.*' => 'nullable|numeric|min:0',
        'efficiencies.*' => 'nullable|string',
    ];

    public function mount(): void
    {
        $this->updateTotalLaborCost();
    }

    public function calculatePartialCost($positionId): void
    {
        if (in_array($positionId, $this->selectedPositions)) {
            $quantity = $this->quantities[$positionId] ?? 0;
            $requiredDays = $this->requiredDays[$positionId] ?? 0;
            $efficiencyInput = $this->efficiencies[$positionId] ?? "1";

            $efficiency = DataTypeConverter::convertToFloat($efficiencyInput);

            if (is_numeric($quantity) && is_numeric($requiredDays) && $efficiency !== null) {
                $position = Position::find($positionId);
                $dailyCost = $position->real_daily_cost;

                $this->partialCosts[$positionId] = $quantity * $requiredDays * $efficiency * $dailyCost;
            } else {
                $this->partialCosts[$positionId] = 0;
            }
        } else {
            $this->partialCosts[$positionId] = 0;
        }
    }

    public function updatedQuantities($value, $positionId): void
    {
        if (!is_numeric($value)) {
            $this->quantities[$positionId] = null;
        }

        $this->calculatePartialCost($positionId);
        $this->updateTotalLaborCost();
    }

    public function updatedRequiredDays($value, $positionId): void
    {
        if (!is_numeric($value)) {
            $this->requiredDays[$positionId] = null;
        }

        $this->calculatePartialCost($positionId);
        $this->updateTotalLaborCost();
    }

    public function updatedEfficiencies($value, $positionId): void
    {
        // Convierte el valor a float usando DataTypeConverter
        $efficiency = DataTypeConverter::convertToFloat($value);

        if ($efficiency === null) {
            // Emitir un mensaje de error si el valor es inválido
            $this->addError('efficiency', 'El valor de eficiencia es inválido.');
            return; // No sigas con el cálculo si el valor es inválido
        }

        // Actualizar el array de eficiencias con el nuevo valor
        $this->efficiencies[$positionId] = $efficiency;
        // Recalcular el costo parcial y total para reflejar cualquier cambio
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
            'quantities' => $this->quantities,
            'requiredDays' => $this->requiredDays,
            'efficiencies' => $this->efficiencies,
            'totalLaborCost' => $this->totalLaborCost,
        ]);

        if ($this->totalLaborCost > 0) {
            $this->dispatch('hideResourceForm');
        }
    }

    public function render(): View
    {
        $this->positions = Position::all();
        return view('livewire.projects.position-selection');
    }
}
