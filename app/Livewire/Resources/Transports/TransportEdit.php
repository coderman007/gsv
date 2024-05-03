<?php

namespace App\Livewire\Resources\Transports;

use App\Models\Transport;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class TransportEdit extends Component
{
    use WithFileUploads;

    public $transportId;
    public $openEdit = false;
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

    public function mount($transportId): void
    {
        $this->transportId = $transportId;
        $transport = Transport::findOrFail($this->transportId);
        $this->vehicle_type = $transport->vehicle_type;
        $this->gasoline_cost_per_km = $transport->gasoline_cost_per_km;
        $this->cost_per_day = $transport->cost_per_day;
        $this->toll_cost = $transport->toll_cost;
    }

    public function updateTransport(): void
    {
        $this->validate();

        $transport = Transport::findOrFail($this->transportId);
        $transport->update([
            'vehicle_type' => $this->vehicle_type,
            'gasoline_cost_per_km' => $this->gasoline_cost_per_km,
            'cost_per_day' => $this->cost_per_day,
            'toll_cost' => $this->toll_cost,
        ]);


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
