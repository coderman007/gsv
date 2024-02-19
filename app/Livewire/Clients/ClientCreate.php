<?php

namespace App\Livewire\Clients;

use App\Models\City;
use App\Models\Country;
use App\Models\Department;
use App\Models\Location;
use App\Models\Client;
use Livewire\Component;

class ClientCreate extends Component
{
    public $openCreate = false;

    public $name;
    public $email;
    public $phone;
    public $transformer = "";
    public $average_energy_consumption;
    public $roof_dimension;
    public $image;
    public $status = "";

    protected $rules = [
        'location_id' => 'required',
        'name' => 'required',
        'email' => 'required|email',
        'phone' => 'required',
        'transformer' => 'required',
        'average_energy_consumption' => 'required|numeric',
        'roof_dimension' => 'required|numeric',
        'status' => 'required',
        'image' => 'nullable|file|mimes:jpeg,png,jpg|max:2048', // Maximum file size: 2 MB

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
