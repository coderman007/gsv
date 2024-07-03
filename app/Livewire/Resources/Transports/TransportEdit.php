<?php

namespace App\Livewire\Resources\Transports;

use App\Events\TransportUpdated;
use App\Models\Transport;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

class TransportEdit extends Component
{
    use WithFileUploads;

    public $transportId;
    public $openEdit = false;
    public $vehicle_type;
    public $capacity;
    public $cost_per_day;
    public $fuel_type;
    public $showVehicleTypeDropdown = false;

    protected $rules = [
        'vehicle_type' => 'required|string', // Modificar la validación para aceptar cualquier cadena
        'capacity' => 'nullable|numeric|min:0',
        'cost_per_day' => 'required|numeric|min:0',
        'fuel_type' => 'nullable|string',
    ];

    public function mount($transportId): void
    {
        $this->transportId = $transportId;
        $transport = Transport::findOrFail($this->transportId);
        $this->vehicle_type = $transport->vehicle_type;
        $this->capacity = $transport->capacity;
        $this->cost_per_day = $transport->cost_per_day;
        $this->fuel_type = $transport->fuel_type;
    }

    public function toggleVehicleTypeDropdown(): void
    {
        $this->showVehicleTypeDropdown = !$this->showVehicleTypeDropdown;
    }

    public function updateTransport(): void
    {
        $this->validate();

        $transport = Transport::findOrFail($this->transportId);
        $transport->update([
            'vehicle_type' => $this->vehicle_type,
            'capacity' => $this->capacity,
            'cost_per_day' =>$this->cost_per_day,
            'fuel_type' => $this->fuel_type,
        ]);

        event(new TransportUpdated($transport));

        $this->dispatch('updatedTransport', $transport);
        $this->dispatch('updatedTransportNotification');
        $this->openEdit = false;
    }

    public function render(): View
    {
        $transport = Transport::findOrFail($this->transportId);
        return view('livewire.resources.transports.transport-edit', compact('transport'));
    }
}
