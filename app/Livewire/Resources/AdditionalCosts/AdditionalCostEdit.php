<?php

namespace App\Livewire\Resources\AdditionalCosts;

use App\Models\AdditionalCost;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

class AdditionalCostEdit extends Component
{
    use WithFileUploads;

    public $additionalCostId;
    public $openEdit = false;
    public $name, $description, $unitPrice;

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string|max:255',
        'unitPrice' => 'required|numeric|min:0',
    ];

    public function mount($additionalCostId): void
    {
        $this->additionalCostId = $additionalCostId;
        $additionalCost = AdditionalCost::findOrFail($additionalCostId);
        $this->name = $additionalCost->name;
        $this->description = $additionalCost->description;
        $this->unitPrice = $additionalCost->unit_price;
    }

    public function updateAdditionalCost(): void
    {
        $this->validate();

        $additionalCost = AdditionalCost::findOrFail($this->additionalCostId);
        $additionalCost->update([
            'name' => $this->name,
            'description' => $this->description,
            'unit_price' => $this->unitPrice,
        ]);

        $this->dispatch('updatedAdditionalCost', $additionalCost);
        $this->dispatch('updatedAdditionalCostNotification');
        $this->reset('name', 'description', 'unitPrice');
        $this->openEdit = false;
    }

    public function render(): View
    {
        $additionalCost = AdditionalCost::findOrFail($this->additionalCostId);
        return view('livewire.resources.additional-costs.additional-cost-edit', compact('additionalCost'));
    }

}
