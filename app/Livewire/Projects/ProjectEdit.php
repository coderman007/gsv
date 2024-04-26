<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use App\Models\ProjectCategory;
use Illuminate\View\View;
use Livewire\Component;

class ProjectEdit extends Component
{
    public $openEdit = false;
    public $project, $categories, $selectedCategory, $name, $zone, $kilowattsToProvide, $status;

    protected $rules = [
        'selectedCategory' => 'required|exists:project_categories,id',
        'name' => 'required|string|max:255',
        'zone' => 'required|string|max:255',
        'kilowattsToProvide' => 'required|numeric|min:0',
        'status' => 'required|string|max:255',
    ];

    public function mount(Project $project): void
    {
        $this->project = $project;
        $this->categories = ProjectCategory::all();
        $this->selectedCategory = $project->project_category_id;
        $this->name = $project->name;
        $this->zone = $project->zone;
        $this->kilowattsToProvide = $project->kilowatts_to_provide;
        $this->status = $project->status;
    }

    public function updateProject(): void
    {
        $this->validate();

        $this->project->update([
            'project_category_id' => $this->selectedCategory,
            'name' => $this->name,
            'zone' => $this->zone,
            'kilowatts_to_provide' => $this->kilowattsToProvide,
            'status' => $this->status,
        ]);

        // Emitir el evento Livewire después de la actualización
        $this->dispatch('updatedProject', $this->project);
        $this->dispatch('updatedProjectNotification');
        $this->openEdit = false;
    }

    public function render(): View
    {
        return view('livewire.projects.project-edit');
    }
}
