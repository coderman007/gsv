<?php

namespace App\Livewire\Projects;

use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\ProjectType;
use Livewire\WithPagination;

class ProjectList extends Component
{
    use WithPagination;

    public $project;
    public $search = '';
    public $sortBy = 'id';
    public $sortDirection = 'asc';
    public $perSearch = 10;

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
    #[Computed()]
    public function projects()
    {
        return
            Project::where('id', 'like', '%' . $this->search . '%')
            ->orWhere('name', 'like', '%' . $this->search . '%')
            ->orWhere('project_type', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perSearch);
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

    public function render()
    {
        $projects = Project::with(['project_category', 'project_type'])
            ->where('quotation_date', 'LIKE', '%' . $this->search . '%')
            ->orWhere('validity_period', 'LIKE', '%' . $this->search . '%')
            ->orWhere('total_quotation_amount', 'LIKE', '%' . $this->search . '%')
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPage);
        return view('livewire.projects.project-list');
    }
}
