<?php

namespace App\Livewire\ProjectCategories;

use Illuminate\View\View;
use Livewire\Component;
use App\Models\ProjectCategory;
use Livewire\WithFileUploads;

class ProjectCategoryEdit extends Component
{
    use WithFileUploads;

    public $openEdit = false;
    public $categoryId;
    public $name, $description, $image, $status = "";
    public $category;

    protected $rules = [
        'name' => 'required|min:5|max:255',
        'description' => 'nullable|string',
        'status' => 'required'
    ];

    public function mount($categoryId): void
    {
        $this->categoryId = $categoryId;
        $this->category = ProjectCategory::findOrFail($categoryId);
        $this->name = $this->category->name;
        $this->description = $this->category->description;
        $this->status = $this->category->status;
    }

    public function updateCategory(): void
    {
        $this->validate();

        // Actualizar la información de la categoría
        $this->category->update([
            'name' => $this->name,
            'description' => $this->description,
            'status' => $this->status,
        ]);

        // Actualizar la imagen de la categoría si se proporciona
        if ($this->image) {
            // Eliminar la imagen anterior si existe
            if ($this->category->image) {
                unlink(public_path('storage/' . $this->category->image));
            }

            // Almacenar la nueva imagen
            $image_url = $this->image->store('categories', 'public');
            $this->category->update(['image' => $image_url]);
        }

        // Emitir el evento Livewire después de la actualización
        $this->dispatch('updatedProjectCategory', $this->category);
        $this->dispatch('updatedProjectCategoryNotification');

        // Restablecer los campos y cerrar el formulario
        $this->reset(['name', 'description', 'status', 'image']);
        $this->openEdit = false;
    }

    public function render(): View
    {
        return view('livewire.project-categories.project-category-edit');
    }
}
