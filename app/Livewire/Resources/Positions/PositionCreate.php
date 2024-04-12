<?php

namespace App\Livewire\Resources\Positions;

use App\Models\Position;
use Illuminate\View\View;
use Livewire\Component;

class PositionCreate extends Component
{
    public $openCreate = false;
    public $name, $basic, $benefitFactor;
    public $realMonthlyCost, $realDailyCost;

    protected $rules = [
        'name' => 'required|min:5|max:255',
        'basic' => 'required|numeric|min:0',
        'benefitFactor' => 'required|numeric|min:0',
        'realMonthlyCost' => 'required|numeric|min:0',
        'realDailyCost' => 'required|numeric|min:0',
    ];

    public function createPosition(): void
    {
        $this->validate();

        $position = Position::create([
            'name' => $this->name,
            'basic' => $this->basic,
            'benefit_factor' => $this->benefitFactor,
            'real_monthly_cost' => $this->realMonthlyCost,
            'real_daily_cost' => $this->realDailyCost,
        ]);

        $this->openCreate = false;

        $this->dispatch('createdPosition', $position);
        $this->dispatch('createdPositionNotification');

        $this->reset('name', 'basic', 'benefitFactor', 'realMonthlyCost', 'realDailyCost');
    }

    public function render(): View
    {
        return view('livewire.resources.positions.position-create');
    }
}
