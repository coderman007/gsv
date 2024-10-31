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
        // Obtener el usuario autenticado
        $user = auth()->user();

        // Verificar si el usuario tiene permisos para actualizar la categoría
        if (!$user || (!$user->hasRole('Administrador'))) {
            abort(403, 'No está autorizado para llevar a cabo esta acción.');
            return;
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
