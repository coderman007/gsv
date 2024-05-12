<?php

namespace App\Livewire\Resources\Additionals;

use App\Models\Additional;
use Illuminate\View\View;
use Livewire\Component;

class AdditionalDelete extends Component
{
    public $openDelete = false;
    public $additional;

    public function mount(Additional $additional): void
    {
        $this->additional = $additional;
    }

    public function deleteAdditional(): void
    {
        // Verificar si el usuario autenticado existe
        if (!auth()->check()) {
            abort(403, 'No está autorizado para llevar a cabo esta acción.');
        }

        // Verificar si el usuario autenticado tiene el rol 'Administrador' y está activo
        if (!auth()->user()->hasRole('Administrador') || auth()->user()->status !== 'Activo') {
            abort(403, 'No está autorizado para llevar a cabo esta acción.');
        }

        // Si el costo adicional a eliminar existe, proceder con la eliminación
        if ($this->additional) {
            $additional = $this->additional->delete();
            $this->dispatch('deletedAdditional', $additional);
            $this->dispatch('deletedAdditionalNotification');
            $this->openDelete = false;
        }
    }

    public function render(): View
    {
        return view('livewire.resources.additionals.additional-delete');
    }
}
