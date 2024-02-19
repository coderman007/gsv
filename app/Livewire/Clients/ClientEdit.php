<?php

namespace App\Livewire\Clients;

use App\Models\Client;
use Livewire\Component;

class ClientEdit extends Component
{
    public $openEdit = false;
    public $client;
    public $name, $address, $phone, $email, $average_energy_consumption, $solar_radiation_level, $roof_dimensions_length, $roof_dimensions_width, $status;

    protected $rules = [
        'name' => 'min:5|max:255',
        'address' => 'string|max:255',
        'phone' => 'string|max:255',
        'email' => 'string|email|max:255',
        'average_energy_consumption' => 'numeric',
        'solar_radiation_level' => 'numeric',
        'roof_dimensions_length' => 'numeric',
        'roof_dimensions_width' => 'numeric',
        'status' => 'in:Active'
    ];
    public function mount(Client $client)
    {
        $this->client = $client;
        $this->name = $client->name;
        $this->address = $client->address;
        $this->phone = $client->phone;
        $this->email = $client->email;
        $this->average_energy_consumption = $client->average_energy_consumption;
        $this->solar_radiation_level = $client->solar_radiation_level;
        $this->roof_dimensions_length = $client->roof_dimensions_length;
        $this->roof_dimensions_width = $client->roof_dimensions_width;
        $this->status = $client->status;
    }

    public function updateClient()
    {
        $validated = $this->validate();
        $client = $this->client->update($validated);
        $this->dispatch('updatedClient', $client);
        $this->openEdit = false;
    }

    public function render()
    {
        return view('livewire.clients.client-edit');
    }
}
