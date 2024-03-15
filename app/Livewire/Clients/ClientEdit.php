<?php

namespace App\Livewire\Clients;

use Livewire\Component;
use App\Models\Client;
use App\Models\City;
use Livewire\WithFileUploads;

class ClientEdit extends Component
{
    use WithFileUploads;

    public $openEdit = false;
    public $client;
    public $cities;
    public $city_id;
    public $city;
    public $filteredCities = [];

    public $type;
    public $name;
    public $document;
    public $email;
    public $address;
    public $phone;
    public $status;
    public $image;

    public function mount(Client $client)
    {
        $this->client = $client;
        $this->cities = City::all()->pluck('name');
        $this->city_id = $client->city_id;
        $this->city = $client->city->name; // Obtener el nombre de la ciudad del cliente
        $this->type = $client->type;
        $this->name = $client->name;
        $this->document = $client->document;
        $this->email = $client->email;
        $this->address = $client->address;
        $this->phone = $client->phone;
        $this->status = $client->status;
    }

    public function updateClient()
    {
        $this->validate([
            'city_id' => 'required|exists:cities,id',
            'type' => 'required|string',
            'name' => 'required|string',
            'document' => 'nullable|string',
            'email' => 'nullable|email|unique:clients,email,' . $this->client->id,
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'status' => 'nullable|string',
            'image'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            $clientData = [
                'city_id' => $this->city_id,
                'type' => $this->type,
                'name' => $this->name,
                'document' => $this->document,
                'email' => $this->email,
                'address' => $this->address,
                'phone' => $this->phone,
                'address' => $this->address,
                'phone' => $this->phone,
                'status' => $this->status,
            ];

            $this->client->update($clientData);

            if ($this->image) {
                $this->client->update(['image' => $this->image->store('clients', 'public')]);
            }

            // Emitir eventos y notificaciones si es necesario
            $this->openEdit = false;
            // Emite el evento Livewire
            $this->dispatch('updatedClient', $clientData);
            // Emite la notificación
            $this->dispatch('updatedClientNotification', [
                'title' => 'Éxito',
                'text' => '¡Cliente Actualizado Exitosamente!',
                'icon' => 'success'
            ]);
        } catch (\Exception $e) {
            // Manejar el error de manera adecuada, por ejemplo, mostrar un mensaje de error
            session()->flash('error', 'Ocurrió un error al actualizar el cliente.');
        }
    }

    public function updatedCity($value)
    {
        // Filtrar las ciudades basadas en la entrada del usuario
        $this->filteredCities = City::where('name', 'like', '%' . $value . '%')->pluck('name');
    }

    public function selectCity($city)
    {
        $selectedCity = City::where('name', $city)->first();
        if ($selectedCity) {
            $this->city = $selectedCity->name; // Para mostrar el nombre en la vista
            $this->city_id = $selectedCity->id; // Para almacenar el ID de la ciudad
        }
        $this->filteredCities = [];
    }


    public function render()
    {
        return view('livewire.clients.client-edit');
    }
}
