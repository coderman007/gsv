<?php

namespace App\Http\Livewire\Resources\Transports;

use Livewire\Component;
use App\Models\Transport;

class TransportCreate extends Component
{
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

    protected $rules = [
        'vehicle_type' => 'required|string|max:255',
        'annual_mileage' => 'required|integer|min:0',
        'average_speed' => 'required|numeric|min:0',
        'commercial_value' => 'required|numeric|min:0',
        'depreciation_rate' => 'required|numeric|min:0|max:100',
        'annual_maintenance_cost' => 'required|numeric|min:0',
        'cost_per_km_conventional' => 'required|numeric|min:0',
        'cost_per_km_fuel' => 'required|numeric|min:0',
        'salary_per_month' => 'required|numeric|min:0',
        'salary_per_hour' => 'required|numeric|min:0',
    ];

    public function createTransport()
    {
        $validatedData = $this->validate();

        Transport::create($validatedData);

        $this->reset();

        $this->emit('createdTransportNotification');
    }

    public function render()
    {
        return view('livewire.resources.transports.transport-create');
    }
}
