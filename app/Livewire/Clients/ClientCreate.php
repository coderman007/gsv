<?php

namespace App\Livewire\Clients;

use App\Models\Client;
use Livewire\Component;

class ClientCreate extends Component
{
    public $openCreate = false;
    public $name, $address, $phone, $email, $average_energy_consumption, $solar_radiation_level, $roof_dimensions_length, $roof_dimensions_width;
    public $status = "";

    protected $rules = [
        'name' => 'required',
        'address' => 'required',
        'phone' => 'required',
        'email' => 'required|email',
        'average_energy_consumption' => 'required|numeric',
        'solar_radiation_level' => 'required|numeric',
        'roof_dimensions_length' => 'required|numeric',
        'roof_dimensions_width' => 'required|numeric',
        'status' => 'required',

    ];
    public function createClient()
    {
        $this->validate();
        $client = Client::create([
            'name' => $this->name,
            'address' => $this->address,
            'phone' => $this->phone,
            'email' => $this->email,
            'average_energy_consumption' => $this->average_energy_consumption,
            'solar_radiation_level' => $this->solar_radiation_level,
            'roof_dimensions_length' => $this->roof_dimensions_length,
            'roof_dimensions_width' => $this->roof_dimensions_width,
            'status' => $this->status,

        ]);

        $this->openCreate = false;
        // session()->flash('message', 'Usuario Creado Satisfactoriamente!');
        // $message = session('message');
        $this->dispatch('createdClient', $client);
        $this->dispatch('newClientNotification', [
            'title' => 'Success',
            'text' => 'Cliente Creado Exitosamente!',
            'icon' => 'success'
        ]);
        $this->reset();
    }
    public function render()
    {
        return view('livewire.clients.client-create');
    }
}
