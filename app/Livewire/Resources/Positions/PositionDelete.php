<?php

namespace App\Livewire\Resources\Positions;

use App\Models\Position;
use Livewire\Component;

class PositionDelete extends Component
{
    public $openDelete = false;
    public $position;

    public function mount(Position $position)
    {
        $this->position = $position;
    }

    public function deletePosition()
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
        if ($this->Position) {
            $position = $this->Position->delete();
            $this->dispatch('deletedPosition', $position);
            $this->dispatch('deletedPositionNotification');
            $this->openDelete = false;
        }
    }

    public function render()
    {
        return view('livewire.resources.positions.position-delete');
    }
}