<?php

namespace App\Livewire\Clients;

use App\Models\Client;
use Livewire\Component;

class ClientCreate extends Component
{
    public $openCreate = false;
    public $location_id, $name, $email, $phone, $average_energy_consumption, $roof_dimension, $image;
    public $status = "";

    protected $rules = [
        'name' => 'required',
        'address' => 'required',
        'phone' => 'required',
        'email' => 'required|email',
        'average_energy_consumption' => 'required|numeric',
        'solar_radiation_level' => 'required|numeric',
        'roof_dimension' => 'required|numeric',
        'status' => 'required',

    ];
    public function createClient()
    {
        $this->validate();
        $client = Client::create([
            'location_id' => $this->location_id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'transformer' => $this->transformer,
            'average_energy_consumption' => $this->average_energy_consumption,
            'roof_dimension' => $this->roof_dimension,
            'status' => $this->status,
            'image' => $this->image,

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
