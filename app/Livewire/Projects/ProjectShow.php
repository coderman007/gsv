<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use Illuminate\View\View;
use Livewire\Component;

class ProjectShow extends Component
{
    public $project;
    public $openShow = false;

    public function mount(Project $project): void
    {
        $this->project = $project;
    }

    public function render(): View
    {
        return view('livewire.projects.project-show');
    }
}
