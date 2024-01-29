<?php

namespace App\Livewire\Projects;

use App\Models\Client;
use Livewire\Component;

use App\Models\Project;

class ProjectEdit extends Component
{

    public $openEdit = false;
    public $project;
    public $clients = [];
    public $client_id;
    public $name;
    public $project_type;
    public $description;
    public $required_kilowatts;
    public $start_date;
    public $expected_end_date;
    public $status = "";
    protected $rules = [
        'client_id' => 'required|exists:clients,id',
        'name' => 'required',
        'project_type' => 'required',
        'description' => 'required',
        'required_kilowatts' => 'required|numeric',
        'start_date' => 'required|date',
        'expected_end_date' => 'required|date',
        'status' => 'required'
    ];
    public function mount(Project $project, Client $client)
    {
        $this->project = $project;
        $this->client_id = $project->client_id;
        $this->name = $project->name;
        $this->project_type = $project->project_type;
        $this->description = $project->description;
        $this->required_kilowatts = $project->required_kilowatts;
        $this->start_date = $project->start_date;
        $this->expected_end_date = $project->expected_end_date;
        $this->status = $project->status;
        $this->clients = $client->all();
    }

    public function updateProject()
    {
        $validated = $this->validate();
        $project = $this->project->update($validated);
        $this->dispatch('updatedProject', $project);
        $this->openEdit = false;
        $this->reset();
    }


    public function render()
    {
        return view('livewire.projects.project-edit');
    }
}
