<?php

namespace App\Livewire\Clients;

use App\Models\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Component;

class ClientDelete extends Component
{
    public $openDelete = false;
    public $client;

    public function mount(Client $client): void
    {
        $this->client = $client;

        // Verificar si el usuario tiene permiso para eliminar
        if ($client->user_id !== Auth::id() && !Auth::user()->hasRole('Administrator')) {
            session()->flash('error', 'No tienes permiso para eliminar este cliente.');
        }
    }

    public function deleteClient(): void
    {
        if ($this->client) {
            $this->client->delete(); // Eliminar el cliente

            // Emitir eventos y notificaciones
            $this->dispatch('deletedClient', $this->client);
            $this->dispatch('deletedClientNotification', [
                'title' => 'Éxito',
                'text' => '¡Cliente Eliminado Exitosamente!',
                'icon' => 'success'
            ]);
            $this->openDelete = false; // Cerrar el modal o ventana de eliminación
        }
    }

    public function render(): View
    {
        return view('livewire.clients.client-delete');
    }
}
