<?php

namespace App\Livewire\Projects;

use App\Helpers\DataTypeConverter;
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
    public $efficiencies = [];
    public $partialCosts = [];
    public $totalTransportCost = 0;

    protected $rules = [
        'selectedTransports' => 'required|array|min:1',
        'selectedTransports.*' => 'exists:transports,id',
        'quantities.*' => 'nullable|numeric|min:0',
        'requiredDays.*' => 'nullable|numeric|min:0',
        'efficiencies.*' => 'nullable|string',
    ];

    public function mount(): void
    {
        $this->updateTotalTransportCost();
    }

    public function calculatePartialCost($transportId): void
    {
        if (in_array($transportId, $this->selectedTransports)) {
            $quantity = $this->quantities[$transportId] ?? 0;
            $requiredDays = $this->requiredDays[$transportId] ?? 0;
            $efficiencyInput = $this->efficiencies[$transportId] ?? "1";

            $efficiency = DataTypeConverter::convertToFloat($efficiencyInput);

            if (is_numeric($quantity) && is_numeric($requiredDays) && $efficiency !== null) {
                $transport = Transport::find($transportId);
                $dailyCost = $transport->cost_per_day;
                $this->partialCosts[$transportId] = $quantity * $requiredDays * $efficiency * $dailyCost;
            } else {
                $this->partialCosts[$transportId] = 0; // Default to zero if invalid
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
        if (!is_numeric($value)) {
            $this->requiredDays[$transportId] = null;
        }

        // Recalcula el costo parcial y total para reflejar cualquier cambio
        $this->calculatePartialCost($transportId);
        $this->updateTotalTransportCost();
    }

    public function updatedEfficiencies($value, $transportId): void
    {
        // Convierte el valor a float usando DataTypeConverter
        $efficiency = DataTypeConverter::convertToFloat($value);

        if ($efficiency === null) {
            // Emitir un mensaje de error si el valor es inválido
            $this->addError('efficiency', 'El valor de eficiencia es inválido.');
            return; // No sigas con el cálculo si el valor es inválido
        }

        // Actualizar el array de eficiencias con el nuevo valor
        $this->efficiencies[$transportId] = $efficiency;
        // Recalcular el costo parcial y total para reflejar cualquier cambio
        $this->calculatePartialCost($transportId);
        $this->updateTotalTransportCost();
    }

    public function updateTotalTransportCost(): void
    {
        $this->totalTransportCost = array_sum($this->partialCosts);
    }

    // Agregar un método para enviar el valor total del transporte
    public function sendTotalTransportCost(): void
    {
        $this->dispatch('totalTransportCostUpdated', $this->totalTransportCost);

        $this->dispatch('transportSelectionUpdated', [
            'selectedTransports' => $this->selectedTransports,
            'transportQuantities' => $this->quantities,
            'transportRequiredDays' => $this->requiredDays,
            'transportEfficiencies' => $this->efficiencies,
            'totalTransportCost' => $this->totalTransportCost,
        ]);

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
