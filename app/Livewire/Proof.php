<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Position;

class Proof extends Component
{
    public $positions;
    public $showInputs = [];
    public $inputData = [];

    public function mount()
    {
        $this->positions = Position::all();
    }

    public function toggleInputs($positionId)
    {
        $this->showInputs[$positionId] = !$this->showInputs[$positionId];
    }

    public function updatePosition($positionId)
    {
        $position = Position::find($positionId);
        $position->update($this->inputData[$positionId]);
        $this->reset(['showInputs', 'inputData']);
    }

    public function render()
    {
        return view('livewire.proof');
    }
}

