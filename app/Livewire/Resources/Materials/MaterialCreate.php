<?php

namespace App\Livewire\Resources\Materials;

use App\Models\Material;
use App\Models\MaterialCategory;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Cache;

class MaterialCreate extends Component
{
    use WithFileUploads;

    public $openCreate = false;
    public $categories, $selectedCategory, $reference, $description, $unitPrice, $image;

    protected $rules = [
        'selectedCategory' => 'required|exists:material_categories,id',
        'reference' => 'required|string|max:255',
        'description' => 'nullable|string|max:255',
        'unitPrice' => 'required|numeric|min:0',
        'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ];

    public function mount(): void
    {
        $this->categories = Cache::remember('material_categories', 3600, function () {
            return MaterialCategory::all();
        });
    }

    public function updatedReference($value): void
    {
        if (strtolower($value) === 'módulo solar') {
            $this->rules['description'] = 'required|numeric|min:1';
        } else {
            $this->rules['description'] = 'nullable|string|max:255';
        }
    }

    public function createMaterial(): void
    {
        $this->validate();

        // Verificación adicional antes de crear el material
        if (strtolower($this->reference) === 'módulo solar' && empty($this->description)) {
            throw new \Exception('La descripción es obligatoria para el material "módulo solar".');
        }

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
            'description' => $this->description ?: '',
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
