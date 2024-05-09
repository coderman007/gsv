<?php

namespace App\Livewire\Projects;

use App\Helpers\DataTypeConverter;
use App\Models\Tool;
use Illuminate\View\View;
use Livewire\Component;

class ToolSelection extends Component
{
    public $search = '';
    public $tools = [];
    public $selectedTools = [];
    public $quantities = [];
    public $requiredDays = [];
    public $efficiencyInputs = []; // Mantenemos las entradas como cadenas de texto
    public $efficiencies = []; // Almacenamos las eficiencias como valores numéricos
    public $partialCosts = [];
    public $extraHandToolCost = 0;
    public $totalToolCost = 0;

    protected $rules = [
        'selectedTools' => 'required|array|min:1',
        'selectedTools.*' => 'exists:tools,id',
        'quantities.*' => 'nullable|numeric|min:0',
        'requiredDays.*' => 'nullable|numeric|min:0',
        'efficiencyInputs.*' => 'nullable|string', // Aceptamos cadenas de texto para rendimiento
    ];

    public function mount(): void
    {
        $this->updateTotalToolCost(); // Actualizar el costo total
    }

    public function updatedSearch(): void
    {
        $this->tools = Tool::where('name', 'like', '%' . $this->search . '%')->get(); // Actualizar herramientas según la búsqueda
    }

    public function calculatePartialCost($toolId): void
    {
        if (in_array($toolId, $this->selectedTools)) {
            $quantity = $this->quantities[$toolId] ?? 0;
            $requiredDays = $this->requiredDays[$toolId] ?? 0;
            $efficiencyInput = $this->efficiencyInputs[$toolId] ?? "1"; // Predeterminado a cadena de texto "1"

            $efficiency = DataTypeConverter::convertToFloat($efficiencyInput); // Convertir cadena a número

            if ($efficiency === null) {
                // Establecer el costo parcial en cero si la conversión falla
                $this->partialCosts[$toolId] = 0;
                $this->addError("efficiency_$toolId", "El rendimiento ingresado es inválido.");
                return; // Salir temprano si la conversión falla
            }

            if (is_numeric($quantity) && is_numeric($requiredDays)) {
                $tool = Tool::find($toolId);
                $dailyCost = $tool->unit_price_per_day;

                // Calcular el costo parcial con la eficiencia convertida
                $partialCost = $quantity * $requiredDays * $efficiency * $dailyCost;
                $partialCost += $this->extraHandToolCost; // Sumar costo adicional de herramientas de mano

                $this->partialCosts[$toolId] = $partialCost;
            } else {
                $this->partialCosts[$toolId] = 0; // Establecer el costo parcial en cero si datos son inválidos
            }
        } else {
            $this->partialCosts[$toolId] = 0; // Si la herramienta no está seleccionada, costo parcial es cero
        }
    }

    public function updatedQuantities($value, $toolId): void
    {
        if (!is_numeric($value)) {
            $this->quantities[$toolId] = null; // Restablecer si no es numérico
            return; // Salir temprano si no es numérico
        }

        // Recalcular el costo parcial y el total
        $this->calculatePartialCost($toolId);
        $this->updateTotalToolCost();
    }

    public function updatedRequiredDays($value, $toolId): void
    {
        if (!is_numeric($value)) {
        $this->requiredDays[$toolId] = null; // Restablecer si no es numérico
        return; // Salir temprano si no es numérico
    }

        // Recalcular el costo parcial y total
        $this->calculatePartialCost($toolId);
        $this->updateTotalToolCost();
    }

    public function updatedEfficiencyInputs($value, $toolId): void
    {
        $efficiency = DataTypeConverter::convertToFloat($value); // Intentar convertir a número

        if ($efficiency === null) {
            // Emitir error si la conversión falla
            $this->addError("efficiency_$toolId", "El valor de rendimiento es inválido.");
            return; // Salir temprano si no es convertible a número
        }

        $this->efficiencies[$toolId] = $efficiency; // Actualizar el valor numérico de la eficiencia
        $this->efficiencyInputs[$toolId] = $value; // Mantener la cadena original para visualización

        // Recalcular el costo parcial y total
        $this->calculatePartialCost($toolId);
        $this->updateTotalToolCost();
    }

    public function updateTotalToolCost(): void
    {
        // Suma de todos los costos parciales
        $this->totalToolCost = array_sum($this->partialCosts);
    }

    public function sendTotalToolCost(): void
    {
        $this->dispatch("totalToolCostUpdated", $this->totalToolCost); // Emitir evento para informar cambios

        // Detalles del componente para el almacenamiento
        $this->dispatch("toolSelectionUpdated", [
            "selectedTools" => $this->selectedTools,
            "toolQuantities" => $this->quantities,
            "toolRequiredDays" => $this->requiredDays,
            "toolEfficiencies" => $this->efficiencies,
            "totalToolCost" => $this->totalToolCost,
        ]);

        if ($this->totalToolCost > 0) {
            $this->dispatch("hideResourceForm"); // Ejemplo de otro evento a despachar
        }
    }

    public function render(): View
    {
        if (!empty($this->search)) {
            $this->tools = Tool::where('name', 'like', '%' . $this->search . '%')->get(); // Actualizar herramientas según búsqueda
        }
        return view("livewire.projects.tool-selection"); // Renderizar la vista asociada
    }
}
