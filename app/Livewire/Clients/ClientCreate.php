<?php

namespace App\Livewire\Clients;

use Illuminate\View\View;
use Livewire\Component;
use App\Models\Client;
use App\Models\City;
use Livewire\WithFileUploads;

class ClientCreate extends Component
{
    use WithFileUploads;

    public $openCreate = false;
    public $isEditing = false;
    public $type;
    public $name;
    public $document;
    public $representative;
    public $email;
    public $address;
    public $phone;
    public $image;
    public $city;
    public $city_id;
    public $cities; // Variable para almacenar todas las ciudades
    public $filteredCities = []; // Variable para almacenar las ciudades filtradas

    public function mount(): void
    {
        // Cargar todas las ciudades al inicializar el componente
        $this->cities = City::all()->pluck('name');
    }

    public function createClient(): void
    {
        // Validar datos del cliente y de ubicación
        $this->validate([
            'city_id' => 'required|exists:cities,id',
            'type' => 'required|in:Persona,Empresa',
            'name' => 'required|string',
            'representative' => 'nullable|string',
            'document' => 'nullable|string',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'image'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Almacenar la imagen del cliente si se proporciona
        $image_url = null;
        if ($this->image) {
            $image_url = $this->image->store('clients', 'public');
        }

        // Crear el cliente asociado a esa ubicación y al usuario autenticado
        $clientData = [
            'city_id' => $this->city_id,
            'type' => $this->type,
            'name' => $this->name,
            'document' => $this->document,
            'representative' => $this->representative,
            'email' => $this->email,
            'address' => $this->address,
            'phone' => $this->phone,
            'image' => $image_url,
            'user_id' => auth()->id(), // Asignar el ID del usuario autenticado
        ];

        Client::create($clientData);

        // Reiniciar los datos del formulario después de guardar
        $this->reset([
            'type',
            'name',
            'document',
            'representative',
            'email',
            'address',
            'phone',
            'city',
            'image',
        ]);

        // Emitir eventos y notificaciones
        $this->openCreate = false;
        // Emite el evento Livewire
        $this->dispatch('createdClient', $clientData);
        // Emite la notificación
        $this->dispatch('createdClientNotification', [
            'title' => 'Éxito',
            'text' => '¡Cliente Creado Exitosamente!',
            'icon' => 'success'
        ]);
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


    public function render(): View
    {
        return view('livewire.clients.client-create', [
            'filteredCities' => $this->filteredCities,
            'isEditing' => $this->isEditing,
        ]);
    }
}
