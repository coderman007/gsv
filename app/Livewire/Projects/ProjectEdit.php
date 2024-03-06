<?php

namespace App\Livewire\Projects;

use App\Models\Client;
use App\Models\Project;
use Livewire\Component;

class ProjectEdit extends Component
{

    public $openEdit = false;
    public $project;
    public $clients = [];
    public $client_id;
    public $name;
    public $kilowatts_to_provide;
    public $description;
    public $zone;
    public $start_date;
    public $expected_end_date;
    public $status = "";
    protected $rules = [
        'client_id' => 'exists:clients,id',
        'name' => 'string',
        'kilowatts_to_provide' => 'numeric',
        'description' => 'string',
        'zone' => 'string',
        'start_date' => 'string|date',
        'expected_end_date' => 'string|date',
        'status' => 'string',
    ];
    public function mount(Project $project, Client $client)
    {
        $this->project = $project;
        $this->client_id = $project->client_id;
        $this->name = $project->name;
        $this->kilowatts_to_provide = $project->kilowatts_to_provide;
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
