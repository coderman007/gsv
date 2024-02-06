<?php

namespace App\Livewire\ProjectCategories;

use App\Models\ProjectCategory;
use Livewire\Component;

class ProjectCategoryCreate extends Component
{
    public $openCreate = false;
    public $name, $description, $status;

    protected $rules = [
        'name' => 'required|min:5|max:255',
        'description' => 'required|min:5|max:255',
        'status' => 'required'
    ];

    public function createCategory()
    {
        // Verificar si el usuario autenticado existe
        if (!auth()->check()) {
            abort(403, 'No está autorizado para llevar a cabo esta acción.');
        }

        // Verificar si el usuario autenticado tiene el rol 'Administrador' y está activo
        if (!auth()->user()->hasRole('Administrador') || auth()->user()->status !== 'Activo') {
            abort(403, 'No está autorizado para llevar a cabo esta acción.');
        }

        $this->validate();

        $category = ProjectCategory::create([
            'name' => $this->name,
            'description' => $this->description,
            'status' => $this->status,
        ]);

        $this->openCreate = false;
        $this->dispatch('createdProjectCategory', $category);
        $this->dispatch('createdProjectCategoryNotification');
        $this->reset('name', 'description', 'status');
    }

    public function render()
    {
        return view('livewire.project-categories.project-category-create');
    }
}
