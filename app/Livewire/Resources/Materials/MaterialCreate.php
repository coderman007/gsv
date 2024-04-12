<?php

namespace App\Livewire\Resources\Materials;

use App\Models\Material;
use App\Models\MaterialCategory;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

class MaterialCreate extends Component
{
    use WithFileUploads;

    public $openCreate = false;
    public $categories, $selectedCategory, $reference, $description, $unitPrice, $image;

    protected $rules = [
        'selectedCategory' => 'required|exists:material_categories,id', // Validar que la categoría seleccionada existe en la base de datos
        'reference' => 'required|string|max:255',
        'description' => 'required|string|max:255',
        'unitPrice' => 'required|numeric|min:0',
        'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
    ];

    public function mount(): void
    {
        $this->categories = MaterialCategory::all();
    }

    public function createMaterial(): void
    {
        $this->validate();

        // Almacenar la imagen del cliente si se proporciona
        $image_url = null;
        if ($this->image) {
            $image_url = $this->image->store('materials', 'public');
        }

        // Obtener la categoría seleccionada
        $category = MaterialCategory::find($this->selectedCategory);

        $material = Material::create([
            'material_category_id' => $category->id,
            'reference' => $this->reference,
            'description' => $this->description,
            'unit_price' => $this->unitPrice,
            'image' => $image_url,
        ]);

        $this->openCreate = false;

        // Emitir eventos
        $this->dispatch('createdMaterial', $material);
        $this->dispatch('createdMaterialNotification');

        $this->reset('selectedCategory', 'reference', 'description', 'unitPrice', 'image');
    }

    public function render(): View
    {
        return view('livewire.resources.materials.material-create');
    }
}

