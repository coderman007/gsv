<?php

namespace App\Livewire\Projects;

use App\Models\Transport;
use Illuminate\View\View;
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

    public function mount(): void
    {
        $this->updateTotalTransportCost();
        $this->formattedTotalTransportCost = number_format($this->totalTransportCost, 2);
    }

    public function calculatePartialCost($transportId): void
    {
        $index = in_array($transportId, $this->selectedTransports);

        if ($index !== false && isset($this->quantities[$transportId]) && isset($this->requiredDays[$transportId])) {
            $transport = Transport::find($transportId);

            // Verifica si las cantidades y los días requeridos son numéricos
            if (is_numeric($this->quantities[$transportId]) && is_numeric($this->requiredDays[$transportId])) {
                // Calculate daily cost of the transport
                $dailyCost = $transport->salary_per_hour * 8; // Assuming 8 hours per day

                $this->partialCosts[$transportId] = $this->quantities[$transportId] * $this->requiredDays[$transportId] * $dailyCost;
            } else {
                // Si las cantidades o los días requeridos no son numéricos, establece el costo parcial en cero
                $this->partialCosts[$transportId] = 0;
            }
        } else {
            $this->partialCosts[$transportId] = 0;
        }
    }


    public function updatedQuantities($value, $transportId): void
    {
        // Si el valor no es numérico, establece el valor como null
        if (!is_numeric($value)) {
            $this->quantities[$transportId] = null;
        }

        // Recalcula el costo parcial y total para reflejar cualquier cambio
        $this->calculatePartialCost($transportId);
        $this->updateTotalTransportCost();
    }

    public function updatedRequiredDays($value, $transportId): void
    {
        // Si el valor no es numérico, establece el valor como null
        if (!is_numeric($value)) {
            $this->requiredDays[$transportId] = null;
        }

        // Recalcula el costo parcial y total para reflejar cualquier cambio
        $this->calculatePartialCost($transportId);
        $this->updateTotalTransportCost();
    }

    public function updateTotalTransportCost(): void
    {
        $this->totalTransportCost = array_sum($this->partialCosts);
        $this->formattedTotalTransportCost = number_format($this->totalTransportCost, 2);
    }

    // Agregar un método para enviar el valor total del transporte
    public function sendTotalTransportCost(): void
    {
        $this->dispatch('totalTransportCostUpdated', $this->totalTransportCost);

        $this->dispatch('transportSelectionUpdated', [
            'selectedTransports' => $this->selectedTransports,
            'transportQuantities' => $this->quantities,
            'transportRequiredDays' => $this->requiredDays,
            'totalTransportCost' => $this->totalTransportCost,
        ]);

        // Emitir un evento adicional si el costo total del transporte es mayor que 0
        if ($this->totalTransportCost > 0) {
            $this->dispatch('hideResourceForm');
        }
    }

    public function render(): View
    {
        $this->transports = Transport::all();
        return view('livewire.projects.transport-selection');
    }
}
