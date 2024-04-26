<?php

namespace App\Livewire\Projects;

use App\Models\Position;
use Illuminate\View\View;
use Livewire\Component;

class PositionSelection extends Component
{
    public $positions = [];
    public $selectedPositions = [];
    public $positionQuantities = [];
    public $positionRequiredDays = [];
    public $positionEfficiencies = [];
    public $partialCosts = [];
    public $totalLaborCost = 0;
    public $formattedTotalLaborCost;

    protected $rules = [
        'selectedPositions' => 'required|array|min:1',
        'selectedPositions.*' => 'exists:positions,id',
        'positionQuantities.*' => 'nullable|numeric|min:0',
        'positionRequiredDays.*' => 'nullable|numeric|min:0',
        'positionEfficiencies.*' => ['nullable', 'regex:/^(\d+(\.\d+)?|(\d+\/\d+))$/'],
    ];

    public function mount(): void
    {
        $this->positions = Position::all();
        $this->updateTotalLaborCost();
        $this->formattedTotalLaborCost = number_format($this->totalLaborCost, 2);
    }

    public function calculatePartialCost($positionId): void
    {
        $index = in_array($positionId, $this->selectedPositions);

        if ($index !== false) {
            $quantity = $this->positionQuantities[$positionId] ?? 0;
            $requiredDays = $this->positionRequiredDays[$positionId] ?? 0;
            $efficiencyInput = $this->positionEfficiencies[$positionId] ?? "1";

            $efficiency = 1.0; // Valor por defecto
            $validEfficiency = false;

            if (str_contains($efficiencyInput, '/')) {
                $parts = explode('/', $efficiencyInput);

                if (count($parts) == 2) { // Asegúrate de que haya dos partes
                    $numerator = floatval($parts[0]);
                    $denominator = floatval($parts[1]);

                    if ($denominator != 0) { // Verifica que el denominador no sea cero
                        $efficiency = $numerator / $denominator;
                        $validEfficiency = true;
                    }
                }
            } else {
                $validEfficiency = is_numeric($efficiencyInput); // Verifica si es numérico
                if ($validEfficiency) {
                    $efficiency = floatval($efficiencyInput);
                }
            }

            if ($validEfficiency && is_numeric($quantity) && is_numeric($requiredDays)) {
                $position = Position::find($positionId);
                $this->partialCosts[$positionId] = $quantity * $requiredDays * $efficiency * $position->real_daily_cost;
            } else {
                $this->partialCosts[$positionId] = 0; // Valor por defecto cuando hay entrada no válida
            }
        }
    }


    public function updatedPositionQuantities($value, $positionId): void
    {
        if (!is_numeric($value)) {
            $this->positionQuantities[$positionId] = null;
        }

        $this->calculatePartialCost($positionId);
        $this->updateTotalLaborCost();
    }

    public function updatedPositionRequiredDays($value, $positionId): void
    {
        if (!is_numeric($value)) {
            $this->positionRequiredDays[$positionId] = null;
        }

        $this->calculatePartialCost($positionId);
        $this->updateTotalLaborCost();
    }

    public function updatedPositionEfficiencies($value, $positionId): void
    {
        $this->calculatePartialCost($positionId);
        $this->updateTotalLaborCost();
    }

    public function updateTotalLaborCost(): void
    {
        $this->totalLaborCost = array_sum($this->partialCosts);
        $this->formattedTotalLaborCost = number_format($this->totalLaborCost, 2);
    }

    public function sendTotalLaborCost(): void
    {
        $this->dispatch('totalLaborCostUpdated', $this->totalLaborCost);

        $this->dispatch('positionSelectionUpdated', [
            'selectedPositions' => $this->selectedPositions,
            'positionQuantities' => $this->positionQuantities,
            'positionRequiredDays' => $this->positionRequiredDays,
            'positionEfficiencies' => $this->positionEfficiencies,
            'totalLaborCost' => $this->totalLaborCost,
        ]);

        if ($this->totalLaborCost > 0) {
            $this->dispatch('hideResourceForm');
        }
    }

    public function render(): View
    {
        return view('livewire.projects.position-selection');
    }
}
