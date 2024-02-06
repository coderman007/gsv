<?php

namespace App\Livewire\ProjectTypes;

use App\Models\ProjectType;
use Livewire\Component;

class ProjectTypeDelete extends Component
{
    public $openDelete = false;
    public $type;

    public function mount(ProjectType $type)
    {
        $this->type = $type;
    }

    public function deleteProjectType()
    {
        // Verificar si el usuario autenticado existe
        if (!auth()->check()) {
            abort(403, 'No está autorizado para llevar a cabo esta acción.');
        }

        // Verificar si el usuario autenticado tiene el rol 'Administrador' y está activo
        if (!auth()->user()->hasRole('Administrador') || auth()->user()->status !== 'Activo') {
            abort(403, 'No está autorizado para llevar a cabo esta acción.');
        }

        // Si el tipo de proyecto a eliminar existe, proceder con la eliminación
        if ($this->type) {
            $type = $this->type->delete();
            $this->dispatch('deletedProjectType', $type);
            $this->dispatch('deletedProjectTypeNotification');
            $this->openDelete = false;
        }
    }

    public function render()
    {
        return view('livewire.project-types.project-type-delete');
    }
}
