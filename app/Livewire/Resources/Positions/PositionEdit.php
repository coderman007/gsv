<?php

namespace App\Livewire\Resources\Positions;

use App\Events\PositionUpdated;
use App\Models\Position;
use Illuminate\View\View;
use Livewire\Component;

class PositionEdit extends Component
{
    public $openEdit = false;
    public $positionId;
    public $name, $basic, $benefit_factor, $real_monthly_cost, $real_daily_cost;
    public $position;

    protected $rules = [
        'name' => 'required|min:3|max:255',
        'basic' => 'required|numeric|min:0',
        'benefit_factor' => 'required|numeric|min:0|max:100',
        'real_monthly_cost' => 'required|numeric|min:0',
        'real_daily_cost' => 'required|numeric|min:0',
    ];

    public function mount($positionId): void
    {
        $this->positionId = $positionId;
        $this->position = Position::findOrFail($positionId);
        $this->name = $this->position->name;
        $this->basic = $this->position->basic;
        $this->benefit_factor = $this->position->benefit_factor;
        $this->real_monthly_cost = $this->position->real_monthly_cost;
        $this->real_daily_cost = $this->position->real_daily_cost;
    }

    public function updatePosition(): void
    {
        $this->validate();

        $this->position->update([
            'name' => $this->name,
            'basic' => $this->basic,
            'benefit_factor' => $this->benefit_factor,
            'real_monthly_cost' => $this->real_monthly_cost,
            'real_daily_cost' => $this->real_daily_cost,
        ]);

        $this->openEdit = false;
        $this->dispatch('updatedPosition', $this->position);
        $this->dispatch('updatedPositionNotification');

        event(new PositionUpdated($this->position));
    }

    public function render(): View
    {
        return view('livewire.resources.positions.position-edit');
    }
}
