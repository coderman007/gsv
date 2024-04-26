<?php

namespace App\Livewire\Resources\AdditionalCosts;

use App\Models\AdditionalCost;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

/**
 * @property mixed|null $name
 * @property mixed|null $amount
 */
class AdditionalCostCreate extends Component
{
    use WithFileUploads;

    public $openCreate = false;
    public $name, $description, $amount;

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'required|string|max:255',
        'amount' => 'required|numeric|min:0',
    ];

    public function createAdditionalCost(): void
    {
        $this->validate();

        $material = AdditionalCost::create([
            'name' => $this->name,
            'description' => $this->description,
            'amount' => $this->amount,
        ]);

        $this->openCreate = false;

        // Emitir eventos
        $this->dispatch('createdAdditionalCost', $material);
        $this->dispatch('createdAdditionalCostNotification');

        $this->reset('name', 'description', 'amount');
    }

    public function render(): View
    {
        return view('livewire.resources.additional-costs.additional-cost-create');
    }
}

