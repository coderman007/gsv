<?php

namespace App\Livewire\ProjectCategories;

use Livewire\Component;
use App\Models\ProjectCategory;

class ProjectCategoryEdit extends Component
{
    public $openEdit = false;
    public $categoryId;
    public $name, $description, $status = "";
    public $category;

    protected $rules = [
        'name' => 'required|min:5|max:255',
        'description' => 'nullable|string',
        'status' => 'required'
    ];

    public function mount($categoryId)
    {
        $this->categoryId = $categoryId;
        $this->category = ProjectCategory::findOrFail($categoryId);
        $this->name = $this->category->name;
        $this->description = $this->category->description;
        $this->status = $this->category->status;
    }

    public function updateCategory()
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

        $category = ProjectCategory::findOrFail($this->categoryId);

        $category->update([
            'name' => $this->name,
            'description' => $this->description,
            'status' => $this->status,
        ]);

        $this->openEdit = false;
        // Puedes emitir eventos si lo necesitas
        $this->dispatch('updatedProjectCategory', $category);
        $this->dispatch('updatedProjectCategoryNotification');
    }

    public function render()
    {
        return view('livewire.project-categories.project-category-edit');
    }
}
