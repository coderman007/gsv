<?php

namespace App\Livewire\Projects;

use App\Models\Position;
use Illuminate\View\View;
use Livewire\Component;

class PositionSelection extends Component
{
    // Posiciones de Trabajo
    public $positions = [];
    public $selectedPositions = [];
    public $positionQuantities = [];
    public $positionRequiredDays = [];
    public $partialCosts = [];
    public $totalLaborCost = 0;
    public $formattedTotalLaborCost;

    protected $rules = [
        'selectedPositions' => 'required|array|min:1',
        'selectedPositions.*' => 'exists:positions,id',
        'positionQuantities.*' => 'nullable|numeric|min:0',
        'positionRequiredDays.*' => 'nullable|numeric|min:0',
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

        if ($index !== false && isset($this->positionQuantities[$positionId]) && isset($this->positionRequiredDays[$positionId])) {
            if (is_numeric($this->positionQuantities[$positionId]) && is_numeric($this->positionRequiredDays[$positionId])) {
                $position = Position::find($positionId);
                $this->partialCosts[$positionId] = $this->positionQuantities[$positionId] * $this->positionRequiredDays[$positionId] * $position->real_daily_cost;
            } else {
                $this->partialCosts[$positionId] = 0;
            }
        } else {
            $this->partialCosts[$positionId] = 0;
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


    public function updateTotalLaborCost(): void
    {
        $this->totalLaborCost = array_sum($this->partialCosts);
        $this->formattedTotalLaborCost = number_format($this->totalLaborCost, 2);
    }

    // Agregar un método para enviar el valor total de la mano de obra
    public function sendTotalLaborCost(): void
    {
        $this->dispatch('totalLaborCostUpdated', $this->totalLaborCost);

        $this->dispatch('positionSelectionUpdated', [
            'selectedPositions' => $this->selectedPositions,
            'positionQuantities' => $this->positionQuantities,
            'positionRequiredDays' => $this->positionRequiredDays,
            'totalLaborCost' => $this->totalLaborCost,
        ]);

        // Emitir un evento adicional para ocultar el formulario de recursos
        if ($this->totalLaborCost > 0) {
            $this->dispatch('hideResourceForm');
        }
    }

    public function render(): View
    {
        return view('livewire.projects.position-selection');
    }
}
