<?php

namespace App\Livewire\Clients;

use Illuminate\View\View;
use Livewire\Component;
use App\Models\Client;
use App\Models\City;
use Livewire\WithFileUploads;

class ClientEdit extends Component
{
    use WithFileUploads;

    public $isEditing = true;
    public $openEdit = false;
    public $client;
    public $cities;
    public $city_id;
    public $city;
    public $filteredCities = [];

    public $type;
    public $name;
    public $representative;
    public $document;
    public $email;
    public $address;
    public $phone;
    public $image;
    public $status;

    public function mount(Client $client): void
    {
        $this->client = $client;
        $this->cities = City::all()->pluck('name');
        $this->city_id = $client->city_id;
        $this->city = $client->city->name;
        $this->type = $client->type;
        $this->name = $client->name;
        $this->document = $client->document;
        $this->representative = $client->representative;
        $this->email = $client->email;
        $this->address = $client->address;
        $this->phone = $client->phone;
        $this->status = $client->status;
    }

    public function updateClient(): void
    {
        $this->validate([
            'city_id' => 'required|exists:cities,id',
            'type' => 'required|string',
            'name' => 'required|string',
            'document' => 'nullable|string',
            'representative' => 'nullable|string',
            'email' => 'nullable|email|unique:clients,email,' . $this->client->id,
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'nullable|string',
        ]);

        try {
            $clientData = [
                'city_id' => $this->city_id,
                'type' => $this->type,
                'name' => $this->name,
                'document' => $this->document,
                'representative' => $this->representative,
                'email' => $this->email,
                'address' => $this->address,
                'phone' => $this->phone,
                'status' => $this->status,
            ];

            // Actualiza los datos del cliente sin alterar el user_id
            $this->client->update($clientData);

            // Procesa la imagen si se cargó una nueva
            if ($this->image) {
                $image_url = $this->image->store('clients', 'public');
                $this->client->update(['image' => $image_url]);
            }

            // Emitir eventos y notificaciones si es necesario
            $this->openEdit = false;
            $this->dispatch('updatedClient', $clientData);
            $this->dispatch('updatedClientNotification', [
                'title' => 'Éxito',
                'text' => '¡Cliente Actualizado Exitosamente!',
                'icon' => 'success'
            ]);
        } catch (\Exception $e) {
            session()->flash('error', 'Ocurrió un error al actualizar el cliente.');
        }
    }


    public function updatedCity($value): void
    {
        // Filtrar las ciudades basadas en la entrada del usuario
        $this->filteredCities = City::where('name', 'like', '%' . $value . '%')->pluck('name');
    }

    public function selectCity($city): void
    {
        $selectedCity = City::where('name', $city)->first();
        if ($selectedCity) {
            $this->city = $selectedCity->name; // Para mostrar el nombre en la vista
            $this->city_id = $selectedCity->id; // Para almacenar el ID de la ciudad
        }
        $this->filteredCities = [];
    }


    public function render():View
    {
        return view('livewire.clients.client-edit', ['isEditing' => $this->isEditing,]);
    }
}
