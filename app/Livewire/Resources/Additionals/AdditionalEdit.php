<?php

namespace App\Livewire\Resources\Additionals;

use App\Models\Additional;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

class AdditionalEdit extends Component
{
    use WithFileUploads;

    public $additionalId;
    public $openEdit = false;
    public $name, $description, $unitPrice;

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string|max:255',
        'unitPrice' => 'required|numeric|min:0',
    ];

    public function mount($additionalId): void
    {
        $this->additionalId = $additionalId;
        $additional = Additional::findOrFail($additionalId);
        $this->name = $additional->name;
        $this->description = $additional->description;
        $this->unitPrice = $additional->unit_price;
    }

    public function updateAdditional(): void
    {
        $this->validate();

        $additional = Additional::findOrFail($this->additionalId);
        $additional->update([
            'name' => $this->name,
            'description' => $this->description,
            'unit_price' => $this->unitPrice,
        ]);

        $this->dispatch('updatedAdditional', $additional);
        $this->dispatch('updatedAdditionalNotification');
        $this->reset('name', 'description', 'unitPrice');
        $this->openEdit = false;
    }

    public function render(): View
    {
        $additional = Additional::findOrFail($this->additionalId);
        return view('livewire.resources.additionals.additional-edit', compact('additional'));
    }

}
