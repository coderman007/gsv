<?php

namespace App\Livewire\Resources\Positions;

use App\Models\Position;
use Livewire\Component;

class PositionShow extends Component
{
    public $openShow = false;
    public $position;

    public function mount(Position $position)
    {
        $this->position = $position;
    }

    public function render()
    {
        return view('livewire.resources.positions.position-show');
    }
}