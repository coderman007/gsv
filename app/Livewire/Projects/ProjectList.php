<?php

namespace App\Livewire\Projects;

use Livewire\Component;
use App\Models\Project;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class ProjectList extends Component
{
    use WithPagination;

    public $search = '';
    public $sortBy = 'id';
    public $sortDirection = 'asc';
    public $perPage = 10;
    public $selectedCategory = null;

    public function updatingSearch()
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
    }

    public function render()
    {
        $query = Project::query();

        // Filtrar por categoría si se ha seleccionado una
        if ($this->selectedCategory) {
            $query->whereHas('project_category', function ($query) {
                $query->where('id', $this->selectedCategory);
            });
        }

        $projects = $query->where('id', 'like', '%' . $this->search . '%')
            ->orWhere('name', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.projects.project-list', [
            'projects' => $projects,
        ]);
    }

    #[Computed()]
    public function projects()
    {
        return
            Project::where('id', 'like', '%' . $this->search . '%')
            ->orWhere('name', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPage);
    }

    #[On('createdProject')]
    public function createdProject($project = null)
    {
    }

    #[On('updatedProject')]
    public function updatedProject($project = null)
    {
    }

    #[On('deletedProject')]
    public function deletedProject($project = null)
    {
    }
}
