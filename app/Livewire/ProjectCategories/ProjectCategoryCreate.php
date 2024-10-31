<?php

namespace App\Livewire\ProjectCategories;

use App\Models\ProjectCategory;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProjectCategoryCreate extends Component
{
    use WithFileUploads;

    public $openCreate = false;
    public $name, $description, $status, $image;

    protected $rules = [
        'name' => 'required|min:5|max:255',
        'description' => 'required|min:5|max:255',
        'status' => 'required',
        'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ];

    public function createCategory(): void
    {
        // Obtener el usuario autenticado
        $user = auth()->user();

        // Verificar si el usuario tiene permisos para actualizar la categoría
        if (!$user || (!$user->hasRole('Administrador'))) {
            abort(403, 'No está autorizado para llevar a cabo esta acción.');
            return;
        }

        $this->validate();

        // Almacenar la imagen de la categoría si se proporciona
        $image_url = null;
        if ($this->image) {
            $image_url = $this->image->store('categories', 'public');
        }


        $projectCategory = ProjectCategory::create([
            'name' => $this->name,
            'description' => $this->description,
            'status' => $this->status,
            'image' => $image_url,
        ]);

        // Emitir el evento Livewire después de la creación
        $this->dispatch('createdProjectCategory', $projectCategory);
        $this->dispatch('createdProjectCategoryNotification');

        // Restablecer los campos y cerrar el formulario
        $this->reset(['name', 'description', 'status', 'image']);
        $this->openCreate = false;
    }

    public function render(): View
    {
        return view('livewire.project-categories.project-category-create');
    }
}
