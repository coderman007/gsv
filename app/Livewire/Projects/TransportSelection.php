<?php

namespace App\Livewire\Projects;

use App\Models\Transport;
use Livewire\Component;

class TransportSelection extends Component
{
    // Transportes
    public $transports = [];
    public $selectedTransports = [];
    public $quantities = [];
    public $requiredDays = [];
    public $partialCosts = [];
    public $totalTransportCost = 0;
    public $formattedTotalTransportCost;

    protected $rules = [
        'selectedTransports' => 'required|array|min:1',
        'selectedTransports.*' => 'exists:transports,id',
        'quantities.*' => 'nullable|numeric|min:0',
        'requiredDays.*' => 'nullable|numeric|min:0',
    ];

    public function mount()
    {
        $this->updateTotalTransportCost();
        $this->formattedTotalTransportCost = number_format($this->totalTransportCost, 2);
    }

    public function calculatePartialCost($transportId)
    {
        $index = array_search($transportId, $this->selectedTransports);

        if ($index !== false && isset($this->quantities[$transportId]) && isset($this->requiredDays[$transportId])) {
            $transport = Transport::find($transportId);

            // Calculate daily cost of the transport
            $dailyCost = $transport->salary_per_hour * 8; // Assuming 8 hours per day

            $this->partialCosts[$transportId] = $this->quantities[$transportId] * $this->requiredDays[$transportId] * $dailyCost;
        } else {
            $this->partialCosts[$transportId] = 0;
        }
    }

    public function updatedQuantities($value, $transportId)
    {
        $this->calculatePartialCost($transportId);
        $this->updateTotalTransportCost();
    }

    public function updatedRequiredDays($value, $transportId)
    {
        $this->calculatePartialCost($transportId);
        $this->updateTotalTransportCost();
    }

    public function updateTotalTransportCost()
    {
        $this->totalTransportCost = array_sum($this->partialCosts);
        $this->formattedTotalTransportCost = number_format($this->totalTransportCost, 2);
    }

    // Agregar un método para enviar el valor total del transporte
    public function sendTotalTransportCost()
    {
        $this->dispatch('totalTransportCostUpdated', $this->totalTransportCost);

        // Emitir un evento adicional si el costo total del transporte es mayor que 0
        if ($this->totalTransportCost > 0) {
            $this->dispatch('hideResourceForm');
        }
    }

    public function render()
    {
        $this->transports = Transport::all();
        return view('livewire.projects.transport-selection');
    }
}
