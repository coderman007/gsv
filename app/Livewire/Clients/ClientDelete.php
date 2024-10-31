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
    }

    public function deleteClient(): void
    {
        // Obtener el usuario autenticado
        $user = auth()->user();

        // Verificar si el usuario tiene permisos para actualizar el cliente
        if (!$user || (!$user->hasRole('Administrador')) && (!$user->hasRole('Vendedor') && $this->client->user_id !== $user->id)) {
            abort(403, 'No está autorizado para llevar a cabo esta acción.');
            return;
        }

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
