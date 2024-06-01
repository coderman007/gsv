<?php

namespace App\Livewire\Resources\Positions;

use App\Models\Position;
use Illuminate\View\View;
use Livewire\Component;

class PositionShow extends Component
{
    public $openShow = false;
    public $position;

    public function mount(Position $position): void
    {
        $this->position = $position;
    }

    public function render(): View
    {
        return view('livewire.resources.positions.position-show');
    }
}
