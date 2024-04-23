<?php

namespace App\Livewire\Resources\Irradiances;

use App\Models\City;
use Illuminate\View\View;
use Livewire\Component;

/**
 * @property $cityName
 * @property $updatedIrradiance
 */
class IrradianceEdit extends Component
{

    public $search = '';
    public $cities = [];
    public $selectedCity;
    public $irradiance;

    public function updatedSearch(): void
    {
        if ($this->search === '') {
            // Si el campo de búsqueda está vacío, mostrar todas las ciudades
            $this->cities = City::all();
        } else {
            // Si hay texto en el campo de búsqueda, filtrar las ciudades
            $this->cities = City::where('name', 'like', '%' . $this->search . '%')->get();
        }
    }

    public function selectCity($cityId): void
    {
        // Selecciona la ciudad y obtiene la irradiance para editarla
        $this->selectedCity = City::find($cityId);
        $this->irradiance = $this->selectedCity->irradiance;

        // Limpia el campo de búsqueda y borra la lista de ciudades para ocultar sugerencias
        $this->search = '';  // Restablece el campo de búsqueda
        $this->cities = [];  // Vacía la lista de ciudades
    }


    public function updateIrradiance(): void
    {
        // Validar el valor de irradiancia antes de guardar
        $this->validate([
            'irradiance' => 'required|numeric|min:0',
        ]);

        if ($this->selectedCity) {
            // Actualiza la irradiancia de la ciudad seleccionada
            $this->selectedCity->irradiance = $this->irradiance;
            $this->selectedCity->save();

            $this->cityName = $this->selectedCity->name;
            $this->updatedIrradiance = $this->irradiance;
            $this->dispatch('updatedIrradianceNotification', $this->cityName, $this->updatedIrradiance);

            // Limpia el campo de búsqueda y reinicia la lista de ciudades
            $this->search = '';
            $this->cities = [];
            $this->selectedCity = null;
        }
    }



    public function render(): View
    {
        return view('livewire.resources.irradiances.irradiance-edit');
    }
}
