<?php

namespace App\Livewire\Projects;

use App\Models\Client;
use App\Models\Project;
use Livewire\Component;

class ProjectCreate extends Component
{
    public $openCreate = false;
    public $clients = [];
    public $client_id;
    public $project_name;
    public $project_type;
    public $description;
    public $required_kilowatts;
    public $start_date;
    public $expected_end_date;
    public $status = "";

    protected $rules = [
        'client_id' => 'required|exists:clients,id',
        'project_name' => 'required',
        'project_type' => 'required',
        'description' => 'required',
        'required_kilowatts' => 'required|numeric',
        'start_date' => 'required|date',
        'expected_end_date' => 'required|date',
        'status' => 'required',

    ];
    public function createProject()
    {
        $this->validate();
        $project = Project::create([
            'client_id' => $this->client_id,
            'project_name' => $this->project_name,
            'project_type' => $this->project_type,
            'description' => $this->description,
            'required_kilowatts' => $this->required_kilowatts,
            'start_date' => $this->start_date,
            'expected_end_date' => $this->expected_end_date,
            'status' => $this->status,

        ]);

        $this->openCreate = false;
        // session()->flash('message', 'Usuario Creado Satisfactoriamente!');
        // $message = session('message');
        $this->dispatch('createdProject', $project);
        $this->dispatch('newProjectNotification', [
            'title' => 'Success',
            'text' => 'Proyecto Creado Exitosamente!',
            'icon' => 'success'
        ]);
        $this->reset();
    }

    public function mount(Client $clientModel)
    {
        $this->clients = $clientModel->all();
    }
    public function render()
    {
        return view('livewire.projects.project-create');
    }
}
