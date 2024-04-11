<?php

namespace App\Livewire\ProjectCategories;

use Illuminate\View\View;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use App\Models\ProjectCategory;
use Livewire\WithPagination;

class ProjectCategoryList extends Component
{
    use WithPagination;

    public $search = '';
    public $sortBy = 'id';
    public $sortDirection = 'asc';
    public $perSearch = 10;
    public $showFullDescription = false; // Nuevo estado

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function order($sort): void
    {
        if ($this->sortBy == $sort) {
            $this->sortDirection = ($this->sortDirection == "desc") ? "asc" : "desc";
        } else {
            $this->sortBy = $sort;
            $this->sortDirection = "asc";
        }
    }

    #[Computed]
    public function projectCategories()
    {
        return ProjectCategory::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('description', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perSearch);
    }

    #[On('createdProjectCategory')]
    public function createdProjectCategory($projectCategory = null): void
    {
        if ($projectCategory) {
            // Recargar la lista de categorías de proyecto
            $this->projectCategories->fresh();
        }
    }

    #[On('notification')]
    public function notify($message = null)
    {
    }

    #[On('updatedProjectCategory')]
    public function updatedProjectCategory($projectCategory = null)
    {
    }

    #[On('deletedProjectCategory')]
    public function deletedProjectCategory($projectCategory = null)
    {
    }

    public function toggleDescription($categoryId): void
    {
        if ($this->showFullDescription === $categoryId) {
            $this->showFullDescription = null;
        } else {
            $this->showFullDescription = $categoryId;
        }
    }

    // Dentro de la clase ProjectCategoryList

    public function closeDescription(): void
    {
        $this->showFullDescription = false;
    }


    public function render():View
    {
        return view('livewire.project-categories.project-category-list');
    }
}
