<?php

namespace App\Livewire\Resources\Transports;

use Livewire\Component;
use App\Models\Transport;

class TransportEdit extends Component
{
    public $openEdit = false;
    public $transportId;
    public $transport;

    public $vehicle_type;
    public $annual_mileage;
    public $average_speed;
    public $commercial_value;
    public $depreciation_rate;
    public $annual_maintenance_cost;
    public $cost_per_km_conventional;
    public $cost_per_km_fuel;
    public $salary_per_month;
    public $salary_per_hour;

    // Reglas de validación
    protected $rules = [
        'vehicle_type' => 'required|string|max:255',
        'annual_mileage' => 'required|integer|min:0',
        'average_speed' => 'required|numeric|min:0',
        'commercial_value' => 'required|numeric|min:0',
        'depreciation_rate' => 'required|numeric|min:0',
        'annual_maintenance_cost' => 'required|numeric|min:0',
        'cost_per_km_conventional' => 'required|numeric|min:0',
        'cost_per_km_fuel' => 'required|numeric|min:0',
        'salary_per_month' => 'required|numeric|min:0',
        'salary_per_hour' => 'required|numeric|min:0',
    ];

    public function mount($transportId)
    {
        try {
            $this->transportId = $transportId;
            $this->transport = Transport::findOrFail($transportId);

            // Asignar valores de la instancia existente a las propiedades públicas
            $this->vehicle_type = $this->transport->vehicle_type;
            $this->annual_mileage = $this->transport->annual_mileage;
            $this->average_speed = $this->transport->average_speed;
            $this->commercial_value = $this->transport->commercial_value;
            $this->depreciation_rate = $this->transport->depreciation_rate;
            $this->annual_maintenance_cost = $this->transport->annual_maintenance_cost;
            $this->cost_per_km_conventional = $this->transport->cost_per_km_conventional;
            $this->cost_per_km_fuel = $this->transport->cost_per_km_fuel;
            $this->salary_per_month = $this->transport->salary_per_month;
            $this->salary_per_hour = $this->transport->salary_per_hour;
        } catch (\Exception $exception) {
            abort(404, ['Recurso no encontrado', $exception->getMessage(),]);
        }
    }

    public function render()
    {
        return view('livewire.resources.transports.transport-edit');
    }

    public function updateTransport()
    {
        $this->validate();

        // Actualizar la instancia del modelo con los nuevos valores
        $this->transport->update([
            'vehicle_type' => $this->vehicle_type,
            'annual_mileage' => $this->annual_mileage,
            'average_speed' => $this->average_speed,
            'commercial_value' => $this->commercial_value,
            'depreciation_rate' => $this->depreciation_rate,
            'annual_maintenance_cost' => $this->annual_maintenance_cost,
            'cost_per_km_conventional' => $this->cost_per_km_conventional,
            'cost_per_km_fuel' => $this->cost_per_km_fuel,
            'salary_per_month' => $this->salary_per_month,
            'salary_per_hour' => $this->salary_per_hour,
        ]);

        $this->openEdit = false;
        $this->dispatch('updatedTransport', $this->transport);
        $this->dispatch('updatedTransportNotification');
    }
}
