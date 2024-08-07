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
        // Verificar permisos para la eliminación
        if (!auth()->check()) {
            abort(403, 'No está autorizado para llevar a cabo esta acción.');
        }

        if (!auth()->user()->hasRole('Administrador') || auth()->user()->status !== 'Activo') {
            abort(403, 'No está autorizado para llevar a cabo esta acción.');
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
