<?php

namespace App\Livewire\ProjectCategories;

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

    public function mount()
    {
        $this->sortBy = 'id';
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function order($sort)
    {
        if ($this->sortBy == $sort) {
            $this->sortDirection = ($this->sortDirection == "desc") ? "asc" : "desc";
        } else {
            $this->sortBy = $sort;
            $this->sortDirection = "asc";
        }

        $this->resetPage();
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
    public function createdProjectCategory($projectCategory = null)
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
    public function render()
    {
        $categories = $this->projectCategories();
        return view('livewire.project-categories.project-category-list', compact('categories'));
    }
}
