<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use Livewire\Component;

class ProjectShow extends Component
{
    public $openShow = false;
    public $project;

    public function mount(Project $project)
    {
        $this->project = $project;
    }
    public function render()
    {
        return view('livewire.projects.project-show');
    }
}