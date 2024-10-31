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
        // Obtener el usuario autenticado
        $user = auth()->user();

        // Verificar si el usuario tiene permisos para actualizar la categoría
        if (!$user || (!$user->hasRole('Administrador'))) {
            abort(403, 'No está autorizado para llevar a cabo esta acción.');
            return;
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
