<?php

namespace App\Livewire\Resources\Labors;

use App\Models\Labor;
use Livewire\Component;

class LaborDelete extends Component
{
    public $openDelete = false;
    public $labor;

    public function mount(Labor $labor)
    {
        $this->labor = $labor;
    }

    public function deleteLabor()
    {
        // Verificar si el usuario autenticado existe
        if (!auth()->check()) {
            abort(403, 'No está autorizado para llevar a cabo esta acción.');
        }

        // Verificar si el usuario autenticado tiene el rol 'Administrador' y está activo
        if (!auth()->user()->hasRole('Administrador') || auth()->user()->status !== 'Activo') {
            abort(403, 'No está autorizado para llevar a cabo esta acción.');
        }

        // Si la mano de obra a eliminar existe, proceder con la eliminación
        if ($this->labor) {
            $labor = $this->labor->delete();
            $this->dispatch('deletedLabor', $labor);
            $this->dispatch('deletedLaborNotification');
            $this->openDelete = false;
        }
    }

    public function render()
    {
        return view('livewire.resources.labors.labor-delete');
    }
}
