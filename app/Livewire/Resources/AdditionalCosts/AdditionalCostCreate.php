<?php

namespace App\Livewire\Resources\AdditionalCosts;

use App\Models\AdditionalCost;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

/**
 * @property mixed|null $name
 * @property mixed|null $unitPrice
 */
class AdditionalCostCreate extends Component
{
    use WithFileUploads;

    public $openCreate = false;
    public $name, $description, $unitPrice;

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string|max:255',
        'unitPrice' => 'required|numeric|min:0',
    ];

    public function createAdditionalCost(): void
    {
        $this->validate();

        $additionalCost = AdditionalCost::create([
            'name' => $this->name,
            'description' => $this->description,
            'unit_price' => $this->unitPrice,
        ]);

        $this->openCreate = false;

        // Emitir eventos
        $this->dispatch('createdAdditionalCost', $additionalCost);
        $this->dispatch('createdAdditionalCostNotification');

        $this->reset('name', 'description', 'unitPrice');
    }

    public function render(): View
    {
        return view('livewire.resources.additional-costs.additional-cost-create');
    }
}

