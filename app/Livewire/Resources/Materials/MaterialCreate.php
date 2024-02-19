<?php

namespace App\Livewire\Resources\Materials;

use App\Models\Material;
use Livewire\Component;

class MaterialCreate extends Component
{
    public $openCreate = false;
    public $category, $reference, $description, $unitPrice;

    protected $rules = [
        'category' => 'required|string|max:255',
        'reference' => 'required|string|max:255',
        'description' => 'required|string|max:255',
        'unitPrice' => 'required|numeric|min:0',
    ];

    public function createMaterial()
    {
        $this->validate();

        $material = Material::create([
            'category' => $this->category,
            'reference' => $this->reference,
            'description' => $this->description,
            'unit_price' => $this->unitPrice,
        ]);

        $this->openCreate = false;

        $this->dispatch('createdMaterial', $material);
        $this->dispatch('createdMaterialNotification');

        $this->reset('category', 'reference', 'description', 'unitPrice');
    }

    public function render()
    {
        return view('livewire.resources.materials.material-create');
    }
}
