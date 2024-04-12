<?php

namespace App\Livewire\Resources\Positions;

use App\Models\Position;
use Illuminate\View\View;
use Livewire\Component;

class PositionDelete extends Component
{
    public $openDelete = false;
    public $position;

    public function mount(Position $position): void
    {
        $this->position = $position;
    }

    public function deletePosition(): void
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
        if ($this->position) {
            $position = $this->position->delete();
            $this->dispatch('deletedPosition', $position);
            $this->dispatch('deletedPositionNotification');
            $this->openDelete = false;
        }
    }

    public function render(): View
    {
        return view('livewire.resources.positions.position-delete');
    }
}
