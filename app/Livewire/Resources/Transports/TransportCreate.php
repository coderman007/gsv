<?php

namespace App\Livewire\Resources\Transports;

use App\Models\Transport;
use Illuminate\View\View;
use Livewire\Component;

class TransportCreate extends Component
{

    public $openCreate = false;
    public $vehicle_type;
    public $capacity;
    public $cost_per_day;
    public $fuel_type;


    protected $rules = [
        'vehicle_type' => 'required|in:motocicleta,automóvil,camión,autobús,van,otro',
        'capacity' => 'nullable|numeric|min:0',
        'cost_per_day' => 'required|numeric|min:0',
        'fuel_type' => 'nullable|string',
    ];

    public function createTransport(): void
    {
        $this->validate();

        $transport = Transport::create([
            'vehicle_type' => $this->vehicle_type,
            'capacity' => $this->capacity ?? 0,
            'cost_per_day' => $this->cost_per_day,
            'fuel_type' => $this->fuel_type,
        ]);

        $this->openCreate = false;

        // Emitir eventos
        $this->dispatch('createdTransport', $transport);
        $this->dispatch('createdTransportNotification');
    }

    public function render(): View
    {
        return view('livewire.resources.transports.transport-create');
    }
}

