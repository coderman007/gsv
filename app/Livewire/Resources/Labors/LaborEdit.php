<?php

namespace App\Livewire\Resources\Labors;

use Livewire\Component;
use App\Models\Labor;

class LaborEdit extends Component
{
    public $openEdit = false;
    public $laborId;
    public $position, $basic, $benefit_factor, $real_monthly_cost, $real_daily_cost;
    public $labor;

    protected $rules = [
        'position' => 'required|min:3|max:255',
        'basic' => 'required|numeric|min:0',
        'benefit_factor' => 'required|numeric|min:0|max:100',
        'real_monthly_cost' => 'required|numeric|min:0',
        'real_daily_cost' => 'required|numeric|min:0',
    ];

    public function mount($laborId)
    {
        $this->laborId = $laborId;
        $this->labor = Labor::findOrFail($laborId);
        $this->position = $this->labor->position;
        $this->basic = $this->labor->basic;
        $this->benefit_factor = $this->labor->benefit_factor;
        $this->real_monthly_cost = $this->labor->real_monthly_cost;
        $this->real_daily_cost = $this->labor->real_daily_cost;
    }

    public function updateLabor()
    {
        // Aquí puedes realizar las validaciones adicionales necesarias

        $this->validate();

        $this->labor->update([
            'position' => $this->position,
            'basic' => $this->basic,
            'benefit_factor' => $this->benefit_factor,
            'real_monthly_cost' => $this->real_monthly_cost,
            'real_daily_cost' => $this->real_daily_cost,
        ]);

        $this->openEdit = false;
        $this->dispatch('updatedLabor', $this->labor);
        $this->dispatch('updatedLaborNotification');
    }

    public function render()
    {
        return view('livewire.resources.labors.labor-edit');
    }
}
