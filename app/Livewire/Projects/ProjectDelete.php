<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use Livewire\Component;

class ProjectDelete extends Component
{
    public $openDelete = false;
    public $project;

    public function mount(Project $project)
    {
        $this->project = $project;
    }
    public function deleteProject()
    {
        if ($this->project) {
            $project = $this->project->delete();
            $this->dispatch('deletedProject', $project);
            $this->openDelete = false;
        }
    }

    public function render()
    {
        return view('livewire.projects.project-delete');
    }
}
