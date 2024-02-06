<?php

namespace App\Livewire\Locations;

use App\Models\City;
use App\Models\Country;
use App\Models\Department;
use App\Models\Location;
use Livewire\Component;

class LocationDropdown extends Component
{
    public $countries;
    public $departments = null;
    public $cities = null;
    public $location = null;
    public $address = null;
    public $selectedCountry = null;
    public $selectedDepartment = null;
    public $selectedCity = null;

    public function mount()
    {
        $this->countries = Country::get(['id', 'name']);
    }

    public function updatedSelectedCountry($countryId)
    {
        $this->selectedDepartment = null;
        $this->selectedCity = null;
        $this->departments = Department::where('country_id', $countryId)->get(['id', 'name']);
    }

    public function updatedSelectedDepartment($departmentId)
    {
        $this->selectedCity = null;
        $this->cities = City::where('department_id', $departmentId)->get(['id', 'name']);
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

        $this->location['address'] = $this->address;
        Location::create($this->location);

        $this->reset();
        $this->dispatch('createdLocation');
    }

    public function render()
    {
        return view('livewire.locations.location-dropdown');
    }
}
