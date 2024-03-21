<?php

namespace App\Livewire\Projects;

use App\Models\Position;
use Livewire\Component;

class PositionSelection extends Component
{
    // Posiciones de Trabajo
    public $positions = [];
    public $selectedPositions = [];
    public $positionQuantities = [];
    public $positionRequiredDays = [];
    public $partialCosts = [];

    protected $rules = [
        'selectedPositions' => 'required|array|min:1',
        'selectedPositions.*' => 'exists:positions,id',
        'positionQuantities.*' => 'nullable|numeric|min:0',
        'positionRequiredDays.*' => 'nullable|numeric|min:0',
    ];

    public function calculatePartialCost($positionId)
    {
        $index = array_search($positionId, $this->selectedPositions);

        if ($index !== false && isset($this->positionQuantities[$positionId]) && isset($this->positionRequiredDays[$positionId])) {
            $position = Position::find($positionId);
            $this->partialCosts[$positionId] = $this->positionQuantities[$positionId] * $this->positionRequiredDays[$positionId] * $position->real_daily_cost;
        } else {
            $this->partialCosts[$positionId] = 0;
        }
    }

    public function updatedPositionQuantities($value, $positionId)
    {
        $this->calculatePartialCost($positionId);
    }

    public function updatedPositionRequiredDays($value, $positionId)
    {
        $this->calculatePartialCost($positionId);
    }


    public function render()
    {
        $allPositions = Position::all();
        return view('livewire.projects.position-selection', compact('allPositions'));
    }
}
