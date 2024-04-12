<?php

namespace App\Livewire\ProjectCategories;

use App\Models\ProjectCategory;
use Livewire\Component;

class ProjectCategoryDelete extends Component
{
    public $openDelete = false;
    public $category;

    public function mount(ProjectCategory $category): void
    {
        $this->category = $category;
    }

    public function deleteCategory(): void
    {
        // Verificar si el usuario autenticado existe
        if (!auth()->check()) {
            abort(403, 'No está autorizado para llevar a cabo esta acción.');
        }

        // Verificar si el usuario autenticado tiene el rol 'Administrador' y está activo
        if (!auth()->user()->hasRole('Administrador') || auth()->user()->status !== 'Activo') {
            abort(403, 'No está autorizado para llevar a cabo esta acción.');
        }

        // Si la categoría a eliminar existe, proceder con la eliminación
        if ($this->category) {
            $category = $this->category->delete();
            $this->dispatch('deletedProjectCategory', $category);
            $this->dispatch('deletedProjectCategoryNotification');
            $this->openDelete = false;
        }
    }

    public function render()
    {
        return view('livewire.project-categories.project-category-delete');
    }
}
