<?php

namespace App\Livewire;

use Livewire\Component;

class StepTwoForm extends Component
{
    public $projects;

    public function mount()
    {
        $this->projects = \App\Models\Project::all();
    }
    public function render()
    {
        return view('livewire.step-two-form');
    }
}
