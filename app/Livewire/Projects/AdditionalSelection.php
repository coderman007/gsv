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
    public $efficiencyInputs = []; // Mantenemos las entradas como cadenas de texto
    public $efficiencies = []; // Almacenamos las eficiencias como valores numéricos
    public $partialCosts = [];
    public $totalAdditionalCost = 0;

    protected $rules = [
        'selectedAdditionals' => 'required|array|min:1',
        'selectedAdditionals.*' => 'exists:additionals,id',
        'quantities.*' => 'nullable|numeric|min:0',
        'efficiencyInputs.*' => 'nullable|string', // Aceptamos cadenas de texto para rendimiento
    ];

    public function mount(): void
    {
        $this->updateTotalAdditionalCost(); // Actualizar el costo total
    }

    public function updatedSearch(): void
    {
        $this->additionals = Additional::where('name', 'like', '%' . $this->search . '%')->get(); // Actualizar additionales según la búsqueda
    }

    public function calculatePartialCost($additionalId): void
    {
        if (in_array($additionalId, $this->selectedAdditionals)) {
            $quantity = $this->quantities[$additionalId] ?? 0;
            $efficiencyInput = $this->efficiencyInputs[$additionalId] ?? "1"; // Predeterminado a cadena de texto "1"

            $efficiency = DataTypeConverter::convertToFloat($efficiencyInput); // Convertir cadena a número

            if ($efficiency === null) {
                // Establecer el costo parcial en cero si la conversión falla
                $this->partialCosts[$additionalId] = 0;
                $this->addError("efficiency_$additionalId", "El rendimiento ingresado es inválido.");
                return; // Salir temprano si la conversión falla
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
            $this->partialCosts[$additionalId] = 0; // Si la herramienta no está seleccionada, costo parcial es cero
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
        $efficiency = DataTypeConverter::convertToFloat($value); // Intentar convertir a número

        if ($efficiency === null) {
            // Emitir error si la conversión falla
            $this->addError("efficiency_$additionalId", "El valor de rendimiento es inválido.");
            return; // Salir temprano si no es convertible a número
        }

        $this->efficiencies[$additionalId] = $efficiency; // Actualizar el valor numérico de la eficiencia
        $this->efficiencyInputs[$additionalId] = $value; // Mantener la cadena original para visualización

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
            $this->additionals = Additional::where('name', 'like', '%' . $this->search . '%')->get(); // Actualizar additionales según búsqueda
        }
        return view("livewire.projects.additional-selection"); // Renderizar la vista asociada
    }
}
