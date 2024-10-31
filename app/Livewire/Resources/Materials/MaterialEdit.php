<?php

namespace App\Livewire\Resources\Materials;

use App\Events\MaterialUpdated;
use App\Models\Material;
use App\Models\MaterialCategory;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

class MaterialEdit extends Component
{
    use WithFileUploads;

    public $materialId;
    public $openEdit = false;
    public $categories, $selectedCategory, $reference, $description, $unitPrice, $image;

    protected $rules = [
        'selectedCategory' => 'required|exists:material_categories,id',
        'reference' => 'required|string|max:255',
        'description' => 'required|string|max:255',
        'unitPrice' => 'required|numeric|min:0',
        'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
    ];

    public function mount($materialId): void
    {
        $this->materialId = $materialId;
        $this->categories = MaterialCategory::all();
        $material = Material::findOrFail($materialId);
        $this->selectedCategory = $material->material_category_id;
        $this->reference = $material->reference;
        $this->description = $material->description;
        $this->unitPrice = $material->unit_price;
    }

    public function updateMaterial(): void
    {
        // Obtener el usuario autenticado
        $user = auth()->user();

        // Verificar si el usuario tiene permisos para actualizar la categoría
        if (!$user || (!$user->hasRole('Administrador'))) {
            abort(403, 'No está autorizado para llevar a cabo esta acción.');
            return;
        }

        $this->validate();

        $category = MaterialCategory::find($this->selectedCategory);

        $material = Material::findOrFail($this->materialId);
        $material->update([
            'material_category_id' => $category->id,
            'reference' => $this->reference,
            'description' => $this->description,
            'unit_price' => $this->unitPrice,
        ]);

        if ($this->image) {
            if ($material->image) {
                Storage::disk('public')->delete($material->image);
            }
            $image_url = $this->image->store('materials', 'public');
            $material->update(['image' => $image_url]);
        }

        // Emitir el evento después de actualizar el transporte
        event(new MaterialUpdated($material));

        $this->dispatch('updatedMaterial', $material);
        $this->dispatch('updatedMaterialNotification');
        $this->reset('selectedCategory', 'reference', 'description', 'unitPrice', 'image');
        $this->openEdit = false;
    }

    public function render(): View
    {
        $material = Material::findOrFail($this->materialId);
        return view('livewire.resources.materials.material-edit', compact('material'));
    }

}
