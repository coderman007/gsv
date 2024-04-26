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
    public $efficiencies = [];

    public $partialCosts = [];
    public $totalTransportCost = 0;
    public $formattedTotalTransportCost;

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
        $this->formattedTotalTransportCost = number_format($this->totalTransportCost, 2);
    }

    public function calculatePartialCost($transportId): void
    {
        if (in_array($transportId, $this->selectedTransports)) {
            $quantity = $this->quantities[$transportId] ?? 0;
            $requiredDays = $this->requiredDays[$transportId] ?? 0;
            $efficiencyInput = $this->efficiencies[$transportId] ?? "1";

            $efficiency = 1.0;
            $validEfficiency = false;

            if (str_contains($efficiencyInput, '/')) {
                $parts = explode('/', $efficiencyInput);
                if (count($parts) == 2) {
                    $numerator = floatval($parts[0]);
                    $denominator = floatval($parts[1]);
                    if ($denominator != 0) {
                        $efficiency = $numerator / $denominator;
                        $validEfficiency = true;
                    }
                }
            } else {
                $validEfficiency = is_numeric($efficiencyInput);
                if ($validEfficiency) {
                    $efficiency = floatval($efficiencyInput);
                }
            }

            if ($validEfficiency && is_numeric($quantity) && is_numeric($requiredDays)) {
                $transport = Transport::find($transportId);
                $dailyCost = $transport->salary_per_hour * 8; // Assuming 8 hours per day
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
        // Si el valor no es numérico, establece el valor como null
        if (!is_numeric($value)) {
            $this->requiredDays[$transportId] = null;
        }

        // Recalcula el costo parcial y total para reflejar cualquier cambio
        $this->calculatePartialCost($transportId);
        $this->updateTotalTransportCost();
    }

    public function updatedEfficiencies($value, $transportId): void
    {
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
        return view('livewire.projects.transport-selection', [
            'efficiencies' => $this->efficiencies, // Pasamos los datos de eficiencia
        ]);
    }
}
