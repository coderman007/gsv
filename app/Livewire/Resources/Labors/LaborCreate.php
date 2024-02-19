<?php

namespace App\Livewire\Resources\Labors;

use App\Models\Labor;
use Livewire\Component;

class LaborCreate extends Component
{
    public $openCreate = false;
    public $position, $basic, $benefitFactor;
    public $realMonthlyCost, $realDailyCost;

    protected $rules = [
        'position' => 'required|min:5|max:255',
        'basic' => 'required|numeric|min:0',
        'benefitFactor' => 'required|numeric|min:0',
        'realMonthlyCost' => 'required|numeric|min:0',
        'realDailyCost' => 'required|numeric|min:0',
    ];

    public function createLabor()
    {
        $this->validate();

        $labor = Labor::create([
            'position' => $this->position,
            'basic' => $this->basic,
            'benefit_factor' => $this->benefitFactor,
            'real_monthly_cost' => $this->realMonthlyCost,
            'real_daily_cost' => $this->realDailyCost,
        ]);

        $this->openCreate = false;

        $this->dispatch('createdLabor', $labor);
        $this->dispatch('createdLaborNotification');

        $this->reset('position', 'basic', 'benefitFactor', 'realMonthlyCost', 'realDailyCost');
    }

    public function render()
    {
        return view('livewire.resources.labors.labor-create');
    }
}
