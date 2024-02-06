<?php

namespace App\Livewire\ProjectTypes;

use Livewire\Component;
use App\Models\ProjectType;

class ProjectTypeEdit extends Component
{
    public $openEdit = false;
    public $typeId;
    public $name, $description, $status = "";
    public $projectType;

    protected $rules = [
        'name' => 'required|min:5|max:255',
        'description' => 'nullable|string',
        'status' => 'required'
    ];

    public function mount($typeId)
    {
        $this->typeId = $typeId;
        $this->projectType = ProjectType::findOrFail($typeId);
        $this->name = $this->projectType->name;
        $this->description = $this->projectType->description;
        $this->status = $this->projectType->status;
    }

    public function updateProjectType()
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

        $projectType = ProjectType::findOrFail($this->typeId);

        $projectType->update([
            'name' => $this->name,
            'description' => $this->description,
            'status' => $this->status,
        ]);

        $this->openEdit = false;
        $this->dispatch('updatedProjectType', $projectType);
        $this->dispatch('updatedProjectTypeNotification');
    }

    public function render()
    {
        return view('livewire.project-types.project-type-edit');
    }
}
