<?php

namespace App\Livewire\Resources\Materials;

use Livewire\Component;
use App\Models\Material;

class MaterialEdit extends Component
{
    public $openEdit = false;
    public $materialId;
    public $category, $reference, $description, $unitPrice;
    public $material;

    protected $rules = [
        'category' => 'required|string|max:255',
        'reference' => 'required|string|max:255',
        'description' => 'required|string|max:255',
        'unitPrice' => 'required|numeric|min:0',
    ];

    public function mount($materialId)
    {
        try {
            $this->materialId = $materialId;
            $this->material = Material::findOrFail($materialId);
            $this->category = $this->material->category;
            $this->reference = $this->material->reference;
            $this->description = $this->material->description;
            $this->unitPrice = $this->material->unit_price;
        } catch (\Exception $exception) {
            abort(404, ['Recurso no encontrado', $exception->getMessage(),]);
        }
    }

    public function updateMaterial()
    {
        $this->validate();

        $this->material->update([
            'category' => $this->category,
            'reference' => $this->reference,
            'description' => $this->description,
            'unit_price' => $this->unitPrice,
        ]);

        $this->openEdit = false;
        $this->dispatch('updatedMaterial', $this->material);
        $this->dispatch('updatedMaterialNotification');
    }

    public function render()
    {
        return view('livewire.resources.materials.material-edit');
    }
}
