<?php

namespace App\Livewire\Resources\Transports;

use App\Models\Transport;
use Illuminate\View\View;
use Livewire\Component;

class TransportDelete extends Component
{
    public $openDelete = false;
    public $transport;

    public function mount(Transport $transport): void
    {
        $this->transport = $transport;
    }

    public function deleteTransport(): void
    {
        // Obtener el usuario autenticado
        $user = auth()->user();

        // Verificar si el usuario tiene permisos para actualizar la categoría
        if (!$user || (!$user->hasRole('Administrador'))) {
            abort(403, 'No está autorizado para llevar a cabo esta acción.');
            return;
        }

        if ($this->transport) {
            $transport = $this->transport->delete();
            $this->dispatch('deletedTransport', $transport);
            $this->dispatch('deletedTransportNotification');
            $this->openDelete = false;
        }
    }

    public function render(): View
    {
        return view('livewire.resources.transports.transport-delete');
    }
}
