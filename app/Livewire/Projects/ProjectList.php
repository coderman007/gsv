<?php

namespace App\Livewire\Projects;

use App\Models\Client;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\Project;
use Livewire\WithPagination;

class ProjectList extends Component
{
    use WithPagination;

    public $client;
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
            ->orWhere('project_name', 'like', '%' . $this->search . '%')
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
        return view('livewire.projects.project-list');
    }
}
