<?php

namespace App\Livewire\Projects;

use App\Helpers\DataTypeConverter;
use App\Models\Transport;
use Illuminate\View\View;
use Livewire\Component;

class TransportSelection extends Component
{
    // Propiedades para transporte
    public $transports = [];
    public $selectedTransports = [];
    public $quantities = [];
    public $requiredDays = [];
    public $efficiencyInputs = []; // Se usa para capturar el rendimiento como cadena de texto
    public $efficiencies = []; // Almacena el rendimiento como valores numéricos
    public $partialCosts = [];
    public $totalTransportCost = 0;

    public $isEdit = false;
    public $existingSelections = []; // Datos existentes en modo edición

    protected $rules = [
        'selectedTransports' => 'required|array|min:1',
        'selectedTransports.*' => 'exists:transports,id',
        'quantities.*' => 'nullable|numeric|min:0',
        'requiredDays.*' => 'nullable|numeric|min:0',
        'efficiencyInputs.*' => 'nullable|string', // Aceptamos cadenas para el rendimiento
    ];

    public function mount(): void
    {
        $this->transports = Transport::all(); // Cargar todos los transportes

        if ($this->isEdit) {
            $this->initializeFromExistingSelections();
        }

        $this->updateTotalTransportCost(); // Actualizar el costo total
    }

    public function initializeFromExistingSelections(): void
    {
        foreach ($this->existingSelections as $selection) {
            $transportId = $selection['transport_id'];
            $this->selectedTransports[] = $transportId;
            $this->quantities[$transportId] = $selection['quantity'];
            $this->requiredDays[$transportId] = $selection['required_days'];
            $this->efficiencyInputs[$transportId] = $selection['efficiency'];
            $this->efficiencies[$transportId] = DataTypeConverter::convertToFloat($selection['efficiency']);
            $this->calculatePartialCost($transportId);
        }
    }

    public function calculatePartialCost($transportId): void
    {
        if (in_array($transportId, $this->selectedTransports)) {
            $quantity = $this->quantities[$transportId] ?? 0;
            $requiredDays = $this->requiredDays[$transportId] ?? 0;
            $efficiencyInput = $this->efficiencyInputs[$transportId] ?? "1"; // Cadena por defecto

            $efficiency = DataTypeConverter::convertToFloat($efficiencyInput); // Convertir a número

            if ($efficiency === null) {
                $this->partialCosts[$transportId] = 0; // Establecer en cero si la conversión falla
                $this->addError("efficiency_$transportId", "Rendimiento inválido: '$efficiencyInput'.");
                return; // Salir temprano si falla la conversión
            }

            if (is_numeric($quantity) && is_numeric($requiredDays)) {
                $transport = Transport::find($transportId);
                $dailyCost = $transport->cost_per_day;

                // Calcular el costo parcial con la eficiencia numérica
                $partialCost = $quantity * $requiredDays * $efficiency * $dailyCost;
                $this->partialCosts[$transportId] = $partialCost;
            } else {
                $this->partialCosts[$transportId] = 0; // Establecer en cero si los datos son inválidos
            }
        } else {
            $this->partialCosts[$transportId] = 0; // Si no está seleccionado, el costo parcial es cero
        }
    }

    public function updatedQuantities($value, $transportId): void
    {
        if (!is_numeric($value)) {
            $this->quantities[$transportId] = null; // Restablecer si no es numérico
            return; // Salir temprano
        }

        $this->calculatePartialCost($transportId); // Recalcular el costo parcial
        $this->updateTotalTransportCost(); // Actualizar el costo total
    }

    public function updatedRequiredDays($value, $transportId): void
    {
        if (!is_numeric($value)) {
            $this->requiredDays[$transportId] = null; // Restablecer si no es numérico
            return; // Salir temprano
        }

        $this->calculatePartialCost($transportId); // Recalcular el costo parcial
        $this->updateTotalTransportCost(); // Actualizar el costo total
    }

    public function updatedEfficiencyInputs($value, $transportId): void
    {
        $efficiency = DataTypeConverter::convertToFloat($value); // Convertir cadena a número

        if ($efficiency === null) {
            // Emitir error si la conversión falla
            $this->addError("efficiency_$transportId", "Valor de rendimiento inválido.");
            return; // Salir temprano si falla la conversión
        }

        $this->efficiencies[$transportId] = $efficiency; // Actualizar con el valor numérico
        $this->efficiencyInputs[$transportId] = $value; // Guardar el valor como cadena

        $this->calculatePartialCost($transportId); // Recalcular el costo parcial
        $this->updateTotalTransportCost(); // Actualizar el costo total
    }

    public function updateTotalTransportCost(): void
    {
        $this->totalTransportCost = array_sum($this->partialCosts); // Suma de todos los costos parciales
    }

    public function sendTotalTransportCost(): void
    {
        $this->dispatch("totalTransportCostUpdated", $this->totalTransportCost); // Emitir evento para informar cambios

        // Detalles para despachar evento de actualización
        $this->dispatch("transportSelectionUpdated", [
            "selectedTransports" => $this->selectedTransports,
            "transportQuantities" => $this->quantities,
            "transportRequiredDays" => $this->requiredDays,
            "transportEfficiencies" => $this->efficiencies,
            "totalTransportCost" => $this->totalTransportCost,
        ]);

        if ($this->totalTransportCost > 0) {
            $this->dispatch("hideResourceForm"); // Otro evento para despachar
        }
    }

    public function render(): View
    {
        return view("livewire.projects.transport-selection"); // Renderizar la vista
    }
}
