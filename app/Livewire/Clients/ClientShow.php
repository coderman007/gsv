<?php

namespace App\Livewire\Clients;

use App\Models\Client;
use Livewire\Component;

class ClientShow extends Component
{
    public $openShow = false;
    public $client;

    public function mount(Client $client)
    {
        $this->client = $client;
    }
    public function render()
    {
        return view('livewire.clients.client-show');
    }
}
