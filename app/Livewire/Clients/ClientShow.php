<?php

namespace App\Livewire\Clients;

use App\Models\Client;
use Illuminate\View\View;
use Livewire\Component;

class ClientShow extends Component
{
    public $openShow = false;
    public $client;

    public function mount(Client $client): void
    {
        $this->client = $client;
    }
    public function render(): View
    {
        return view('livewire.clients.client-show');
    }
}
