<?php

namespace App\Livewire\Projects;

use App\Models\Client;
use App\Models\Project;
use Livewire\Component;

class ProjectCreate extends Component
{
    public $openCreate = false;
    public $projects = [];
    public $project_category_id;
    public $project_type_id;
    public $name;
    public $description;
    public $status = "";

    protected $rules = [
        'project_category_id' => 'required|exists:project_categories,id',
        'project_type_id' => 'required|exists:project_types,id',
        'name' => 'required',
        'description' => 'required',
        'status' => 'required',

    ];
    public function createProject()
    {
        $this->validate();
        $project = Project::create([
            'project_category_id' => $this->project_category_id,
            'project_type_id' => $this->project_type_id,
            'name' => $this->name,
            'description' => $this->description,
            'status' => $this->status,

        ]);

        $this->openCreate = false;
        $this->dispatch('createdProject', $project);
        // $this->dispatch('newProjectNotification', [
        //     'title' => 'Success',
        //     'text' => 'Proyecto Creado Exitosamente!',
        //     'icon' => 'success'
        // ]);
        $this->reset();
    }

    public function mount(Project $projectModel)
    {
        $this->projects = $projectModel->all();
    }
    public function render()
    {
        return view('livewire.projects.project-create');
    }
}
