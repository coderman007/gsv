<?php

namespace App\Livewire;

use Livewire\Component;

class StepForm extends Component
{
    public $currentStep = 1;

    public function render()
    {
        return view('livewire.step-form');
    }

    public function showStep($step)
    {
        $this->currentStep = $step;
    }
}
