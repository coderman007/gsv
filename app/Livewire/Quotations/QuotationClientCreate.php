<?php

namespace App\Livewire\Quotations;

use App\Models\Client;
use App\Models\City;
use Livewire\Component;
use Livewire\WithFileUploads;

class QuotationClientCreate extends Component
{
    use WithFileUploads;

    public $openCreate = false;
    public $type;
    public $name;
    public $document;
    public $email;
    public $address;
    public $phone;
    public $status;
    public $image;
    public $city;
    public $city_id;
    public $cities; // Variable para almacenar todas las ciudades
    public $filteredCities = []; // Variable para almacenar las ciudades filtradas

    public function mount()
    {
        // Cargar todas las ciudades al inicializar el componente
        $this->cities = City::all()->pluck('name');
    }

    public function createClient()
    {
        // Validar datos del cliente y de ubicación
        $this->validate([
            'city_id' => 'required|exists:cities,id',
            'type' => 'required|in:Persona,Empresa',
            'name' => 'required|string',
            'document' => 'nullable|string',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'status' => 'nullable|string',
            'image'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Almacenar la imagen del cliente si se proporciona
        $image_url = null;
        if ($this->image) {
            $image_url = $this->image->store('clients', 'public');
        }

        // Crear el cliente asociado a esa ubicación
        $clientData = [
            'city_id' => $this->city_id,
            'type' => $this->type,
            'name' => $this->name,
            'document' => $this->document,
            'email' => $this->email,
            'address' => $this->address,
            'phone' => $this->phone,
            'status' => $this->status,
            'image' => $image_url,
        ];

        Client::create($clientData);

        // Reiniciar los datos del formulario después de guardar
        $this->reset([
            'type',
            'name',
            'document',
            'email',
            'address',
            'phone',
            'status',
            'city',
            'image',
        ]);

        $this->openCreate = false;
        $this->dispatch('clientStored', $clientData);
        // Emitir el evento Livewire
        $this->dispatch('clientStoredNotification', [
            'title' => 'Success',
            'text' => 'Cliente almacenado con Éxito!',
            'icon' => 'success'
        ]);
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
        return view('livewire.quotations.quotation-client-create', [
            'filteredCities' => $this->filteredCities,
        ]);
    }
}
