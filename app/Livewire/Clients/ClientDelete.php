<?php

namespace App\Livewire\Clients;

use App\Models\Client;
use Livewire\Component;

class ClientDelete extends Component
{
    public $openDelete = false;
    public $client;


    public function mount(Client $client)
    {
        $this->client = $client;
    }

    public function deleteClient()
    {
        if ($this->client) {
            $client = $this->client->delete();
            $this->dispatch('deletedClient', $client);
            $this->dispatch('deletedClientNotification', $client);
            $this->openDelete = false;
        }
    }
    public function render()
    {
        return view('livewire.clients.client-delete');
    }
}
