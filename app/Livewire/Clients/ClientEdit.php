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
        'name' => 'required|min:5|max:255',
        'address' => 'required|max:255',
        'phone' => 'required|max:255',
        'email' => 'required|email|max:255',
        'average_energy_consumption' => 'required|numeric',
        'solar_radiation_level' => 'required|numeric',
        'roof_dimensions_length' => 'required|numeric',
        'roof_dimensions_width' => 'required|numeric',
        'status' => 'required'
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
        $this->reset();
    }

    public function render()
    {
        return view('livewire.clients.client-edit');
    }
}