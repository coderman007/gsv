<?php

namespace App\Livewire\Quotations;

use App\Models\Client;
use App\Models\City;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

class QuotationClientCreate extends Component
{
    use WithFileUploads;

    public $isEditing = false;
    public $openCreate = false;
    public $type;
    public $name;
    public $document;
    public $email;
    public $address;
    public $phone;
    public $image;
    public $city;
    public $city_id;
    public $cities; // Variable para almacenar todas las ciudades
    public $filteredCities = []; // Variable para almacenar las ciudades filtradas

    protected array $rules = [
        'city_id' => 'required|exists:cities,id',
        'type' => 'required|in:Persona,Empresa',
        'name' => 'required|string',
        'document' => 'nullable|string',
        'email' => 'nullable|email',
        'address' => 'nullable|string',
        'phone' => 'nullable|string',
        'image'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ];

    protected array $messages = [
        'city_id.required' => 'Debe seleccionar una ciudad.',
        'city_id.exists' => 'La ciudad seleccionada no es válida.',
        'type.required' => 'Debe seleccionar un tipo de cliente.',
        'type.in' => 'El tipo debe ser Persona o Empresa.',
        'name.required' => 'El nombre es obligatorio.',
        'name.string' => 'El nombre debe ser una cadena de texto.',
        'document.string' => 'El documento debe ser una cadena de texto.',
        'email.email' => 'El correo electrónico debe ser una dirección válida.',
        'address.string' => 'La dirección debe ser una cadena de texto.',
        'phone.string' => 'El teléfono debe ser una cadena de texto.',
        'image.image' => 'El archivo debe ser una imagen.',
        'image.mimes' => 'La imagen debe ser de tipo jpeg, png o jpg.',
        'image.max' => 'La imagen no debe superar los 2MB.',
    ];

    public function mount(): void
    {
        // Cargar todas las ciudades al inicializar el componente
        $this->cities = City::all()->pluck('name');
    }

    public function createClient(): void
    {
        // Obtener el usuario autenticado
        $user = auth()->user();

        // Verificar si el usuario tiene permisos para crear un cliente
        if (!$user || !$user->hasRole(['Administrador', 'Vendedor']) || $user->status !== 'Activo') {
            abort(403, 'No está autorizado para llevar a cabo esta acción.');
        }

        // Validar datos del cliente y de ubicación
        $this->validate();

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
            'email',
            'address',
            'phone',
            'city',
            'image',
        ]);

        $this->openCreate = false;
        $this->dispatch('clientStored', $clientData);
        // Emitir el evento Livewire
        $this->dispatch('clientStoredNotification', [
            'title' => 'Success',
            'text' => 'Cliente almacenado con éxito!',
            'icon' => 'success'
        ]);
    }

    public function updatedCity($value): void
    {
        // Filtrar las ciudades basadas en la entrada del usuario
        $this->filteredCities = City::where('name', 'like', '%' . $value . '%')->pluck('name');
        // Validar el campo city_id basado en la entrada de city
        $this->validateOnly('city_id');
    }

    public function updatedCityId($value): void
    {
        // Validar el campo city_id
        $this->validateOnly('city_id');
    }

    public function updatedType($value): void
    {
        // Validar el campo type
        $this->validateOnly('type');
    }

    public function updatedName($value): void
    {
        // Validar el campo name
        $this->validateOnly('name');
    }

    public function updatedDocument($value): void
    {
        // Validar el campo document
        $this->validateOnly('document');
    }

    public function updatedEmail($value): void
    {
        // Validar el campo email
        $this->validateOnly('email');
    }

    public function updatedAddress($value): void
    {
        // Validar el campo address
        $this->validateOnly('address');
    }

    public function updatedPhone($value): void
    {
        // Validar el campo phone
        $this->validateOnly('phone');
    }

    public function updatedImage($value): void
    {
        // Validar el campo image
        $this->validateOnly('image');
    }

    public function selectCity($city): void
    {
        $selectedCity = City::where('name', $city)->first();
        if ($selectedCity) {
            $this->city = $selectedCity->name; // Para mostrar el nombre en la vista
            $this->city_id = $selectedCity->id; // Para almacenar el ID de la ciudad
        }
        $this->filteredCities = [];
        // Validar el campo city_id después de seleccionar la ciudad
        $this->validateOnly('city_id');
    }

    public function render(): View
    {
        return view('livewire.quotations.quotation-client-create', [
            'filteredCities' => $this->filteredCities,
        ]);
    }
}
