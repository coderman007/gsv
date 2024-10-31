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
        // Obtener el usuario autenticado
        $user = auth()->user();

        // Verificar si el usuario tiene permisos para actualizar la categoría
        if (!$user || (!$user->hasRole('Administrador'))) {
            abort(403, 'No está autorizado para llevar a cabo esta acción.');
            return;
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
