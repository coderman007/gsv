<?php

namespace App\Livewire\Resources\Transports;

use App\Models\Transport;
use Illuminate\View\View;
use Livewire\Component;

class TransportCreate extends Component
{

    public $openCreate = false;
    public $vehicle_type;
    public $gasoline_cost_per_km;
    public $cost_per_day;
    public $toll_cost;


    protected $rules = [
        'vehicle_type' => 'required|in:motocicleta,automóvil,camión,autobús,van,otro',
        'gasoline_cost_per_km' => 'required|numeric|min:0',
        'cost_per_day' => 'required|numeric|min:0',
        'toll_cost' => 'required|numeric|min:0',
    ];

    public function createTransport(): void
    {
        $this->validate();

        $transport = Transport::create([
            'vehicle_type' => $this->vehicle_type,
            'gasoline_cost_per_km' => $this->gasoline_cost_per_km,
            'cost_per_day' => $this->cost_per_day,
            'toll_cost' => $this->toll_cost ?? 0,
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
