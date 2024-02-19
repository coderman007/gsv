<?php

namespace App\Livewire\Locations;

use App\Models\City;
use App\Models\Country;
use App\Models\Department;
use App\Models\Location;
use Livewire\Component;

class LocationDropdown extends Component
{
    public $countries = [];
    public $departments = [];
    public $cities = [];
    public $location = "";
    public $address = [];
    public $selectedCountry = "";
    public $selectedDepartment = "";
    public $selectedCity = "";

    public function mount()
    {
        $this->countries = Country::get(['id', 'name']);
    }

    public function updatedSelectedCountry($countryId)
    {
        $this->selectedDepartment = null;
        $this->selectedCity = null;
        $this->loadDepartments($countryId);
    }

    public function updatedSelectedDepartment($departmentId)
    {
        $this->selectedCity = null;
        $this->loadCities($departmentId);
    }

    public function updatedSelectedCity($cityId)
    {
        $this->location = [
            'city_id' => $cityId,
        ];
    }

    public function saveLocation()
    {
        $this->validate([
            'selectedCity' => 'required',
            'address' => 'required',
        ]);

        // Verificar si la ubicación ya existe
        $existingLocation = Location::where('city_id', $this->selectedCity)
            ->where('address', $this->address)
            ->first();

        if (!$existingLocation) {
            $this->location['address'] = $this->address;

            // Crear la ubicación
            try {
                Location::create($this->location);
                $this->reset();
            } catch (\Exception $e) {
                $this->addError('saveLocation', 'Error al guardar la ubicación.');
            }
        } else {
            $this->addError('saveLocation', 'La ubicación ya existe.');
        }
    }


    // Método para cargar departamentos
    private function loadDepartments($countryId)
    {
        // Implementa lógica para cargar departamentos desde un servicio o repositorio
        $this->departments = Department::where('country_id', $countryId)->get(['id', 'name']);
    }

    // Método para cargar ciudades
    private function loadCities($departmentId)
    {
        // Implementa lógica para cargar ciudades desde un servicio o repositorio
        $this->cities = City::where('department_id', $departmentId)->get(['id', 'name']);
    }

    public function render()
    {
        return view('livewire.locations.location-dropdown');
    }
}
