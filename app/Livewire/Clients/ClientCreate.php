<?php

namespace App\Livewire\Clients;

use App\Models\City;
use App\Models\Country;
use App\Models\Department;
use App\Models\Location;
use App\Models\Client;
use Livewire\Component;
use Livewire\WithFileUploads;

class ClientCreate extends Component
{
    use WithFileUploads;

    public $openCreate = false;

    public $name;
    public $email;
    public $phone;
    public $transformer = "";
    public $average_energy_consumption;
    public $solar_radiation_level;
    public $roof_dimension;
    public $image;
    public $status = "";

    protected $rules = [
        'name' => 'required|string',
        'email' => 'required|email',
        'phone' => 'required|string',
        'transformer' => 'required',
        'average_energy_consumption' => 'required|numeric',
        'solar_radiation_level' => 'required|numeric',
        'roof_dimension' => 'required|numeric',
        'status' => 'required',
        'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ];


    public function createClient()
    {
        $this->validate();

        // Verificar si la ubicación ya existe
        $existingLocation = Location::where('city_id', $this->selectedCity)
            ->where('address', $this->address)
            ->first();

        if (!$existingLocation) {
            // Si la ubicación no existe, la creamos
            $location = Location::create([
                'city_id' => $this->selectedCity,
                'address' => $this->address,
            ]);
        } else {
            // Si la ubicación ya existe, la utilizamos
            $location = $existingLocation;
        }

        // Creamos el cliente y asociamos la ubicación
        $client = Client::create([
            'location_id' => $location->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'transformer' => $this->transformer,
            'average_energy_consumption' => $this->average_energy_consumption,
            'solar_radiation_level' => $this->solar_radiation_level,
            'roof_dimension' => $this->roof_dimension,
            'status' => $this->status,
        ]);

        if ($this->image) {
            $imagePath = $this->image->store('public/clients');
            $client->update(['image' => $imagePath]);
        }

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
