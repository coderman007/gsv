<?php

namespace App\Livewire\ProjectTypes;

use App\Models\ProjectType;
use Livewire\Component;

class ProjectTypeCreate extends Component
{
    public $openCreate = false;
    public $name, $description, $status;

    protected $rules = [
        'name' => 'required|min:5|max:255',
        'description' => 'required|min:5|max:255',
        'status' => 'required'
    ];

    public function createProjectType()
    {
        // Verificar si el usuario autenticado existe
        if (!auth()->check()) {
            abort(403, 'No está autorizado para llevar a cabo esta acción.');
        }

        // Verificar si el usuario autenticado tiene el rol 'Administrador' y está activo
        if (!auth()->user()->hasRole('Administrador') || auth()->user()->status !== 'Activo') {
            abort(403, 'No está autorizado para llevar a cabo esta acción.');
        }

        $this->validate();

        $projectType = ProjectType::create([
            'name' => $this->name,
            'description' => $this->description,
            'status' => $this->status,
        ]);

        $this->openCreate = false;
        $this->dispatch('createdProjectType', $projectType);
        $this->dispatch('createdProjectTypeNotification');
        $this->reset('name', 'description', 'status');
    }

    public function render()
    {
        return view('livewire.project-types.project-type-create');
    }
}
