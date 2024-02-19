<?php

namespace App\Livewire\Resources\Labors;

use App\Models\Labor;
use Livewire\Component;

class LaborShow extends Component
{
    public $openShow = false;
    public $labor;

    public function mount(Labor $labor)
    {
        $this->labor = $labor;
    }

    public function render()
    {
        return view('livewire.resources.labors.labor-show');
    }
}
