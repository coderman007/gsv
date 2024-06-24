<?php

namespace App\Livewire\Projects;

use App\Helpers\DataTypeConverter;
use App\Models\Additional;
use Illuminate\View\View;
use Livewire\Component;

class AdditionalSelection extends Component
{
    public $search = '';
    public $additionals = [];
    public $selectedAdditionals = [];
    public $quantities = [];
    public $efficiencyInputs = []; // Se usa para capturar el rendimiento como cadena de texto
    public $efficiencies = []; // Almacena el rendimiento como valores numéricos
    public $partialCosts = [];
    public $totalAdditionalCost = 0;

    public $isEdit = false;
    public $existingSelections = []; // Datos existentes en modo edición

    protected $rules = [
        'selectedAdditionals' => 'required|array|min:1',
        'selectedAdditionals.*' => 'exists:additionals,id',
        'quantities.*' => 'nullable|numeric|min:0',
        'efficiencyInputs.*' => 'nullable|string', // Aceptamos cadenas para el rendimiento
    ];

    public function mount(): void
    {
        $this->additionals = Additional::all(); // Cargar todos los adicionales

        if ($this->isEdit) {
            $this->initializeFromExistingSelections();
        }

        $this->updateTotalAdditionalCost(); // Actualizar el costo total
    }

    public function initializeFromExistingSelections(): void
    {
        foreach ($this->existingSelections as $selection) {
            $additionalId = $selection['additional_id'];
            $this->selectedAdditionals[] = $additionalId;
            $this->quantities[$additionalId] = $selection['quantity'];
            $this->efficiencyInputs[$additionalId] = $selection['efficiency'];
            $this->efficiencies[$additionalId] = DataTypeConverter::convertToFloat($selection['efficiency']);
            $this->calculatePartialCost($additionalId);
        }
    }

    public function calculatePartialCost($additionalId): void
    {
        if (in_array($additionalId, $this->selectedAdditionals)) {
            $quantity = $this->quantities[$additionalId] ?? 0;
            $efficiencyInput = $this->efficiencyInputs[$additionalId] ?? "1"; // Cadena por defecto

            $efficiency = DataTypeConverter::convertToFloat($efficiencyInput); // Convertir a número

            if ($efficiency === null) {
                $this->partialCosts[$additionalId] = 0; // Establecer en cero si la conversión falla
                $this->addError("efficiency_$additionalId", "Rendimiento inválido: '$efficiencyInput'.");
                return; // Salir temprano si falla la conversión
            }

            if (is_numeric($quantity)) {
                $additional = Additional::find($additionalId);
                $dailyCost = $additional->unit_price;

                // Calcular el costo parcial con la eficiencia convertida
                $partialCost = $quantity * $efficiency * $dailyCost;

                $this->partialCosts[$additionalId] = $partialCost;
            } else {
                $this->partialCosts[$additionalId] = 0; // Establecer el costo parcial en cero si datos son inválidos
            }
        } else {
            $this->partialCosts[$additionalId] = 0; // Si no está seleccionado, el costo parcial es cero
        }
    }

    public function updatedQuantities($value, $additionalId): void
    {
        if (!is_numeric($value)) {
            $this->quantities[$additionalId] = null; // Restablecer si no es numérico
            return; // Salir temprano si no es numérico
        }

        // Recalcular el costo parcial y el total
        $this->calculatePartialCost($additionalId);
        $this->updateTotalAdditionalCost();
    }

    public function updatedEfficiencyInputs($value, $additionalId): void
    {
        $efficiency = DataTypeConverter::convertToFloat($value); // Convertir cadena a número

        if ($efficiency === null) {
            // Emitir error si la conversión falla
            $this->addError("efficiency_$additionalId", "Valor de rendimiento inválido.");
            return; // Salir temprano si falla la conversión
        }

        $this->efficiencies[$additionalId] = $efficiency; // Actualizar con el valor numérico
        $this->efficiencyInputs[$additionalId] = $value; // Guardar el valor como cadena

        // Recalcular el costo parcial y total
        $this->calculatePartialCost($additionalId);
        $this->updateTotalAdditionalCost();
    }

    public function updateTotalAdditionalCost(): void
    {
        // Suma de todos los costos parciales
        $this->totalAdditionalCost = array_sum($this->partialCosts);
    }

    public function sendTotalAdditionalCost(): void
    {
        $this->dispatch("totalAdditionalCostUpdated", $this->totalAdditionalCost); // Emitir evento para informar cambios

        // Detalles del componente para el almacenamiento
        $this->dispatch("additionalSelectionUpdated", [
            "selectedAdditionals" => $this->selectedAdditionals,
            "additionalQuantities" => $this->quantities,
            "additionalEfficiencies" => $this->efficiencies,
            "totalAdditionalCost" => $this->totalAdditionalCost,
        ]);

        if ($this->totalAdditionalCost > 0) {
            $this->dispatch("hideResourceForm"); // Ejemplo de otro evento a despachar
        }
    }

    public function render(): View
    {
        if (!empty($this->search)) {
            $this->additionals = Additional::where('name', 'like', '%' . $this->search . '%')->get(); // Actualizar adicionales según búsqueda
        }
        return view("livewire.projects.additional-selection"); // Renderizar la vista asociada
    }
}
