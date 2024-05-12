<?php

namespace App\Livewire\Projects;

use App\Helpers\DataTypeConverter;
use App\Models\Material;
use Illuminate\View\View;
use Livewire\Component;

class MaterialSelection extends Component
{
    public $search = '';
    public $materials = [];
    public $selectedMaterials = [];
    public $quantities = [];
    public $efficiencyInputs = []; // Mantenemos las entradas como cadenas de texto
    public $efficiencies = []; // Almacenamos las eficiencias como valores numéricos
    public $partialCosts = [];
    public $totalMaterialCost = 0;

    protected $rules = [
        'selectedMaterials' => 'required|array|min:1',
        'selectedMaterials.*' => 'exists:materials,id',
        'quantities.*' => 'nullable|numeric|min:0',
        'efficiencyInputs.*' => 'nullable|string', // Aceptamos cadenas de texto para rendimiento
    ];

    public function mount(): void
    {
        $this->updateTotalMaterialCost(); // Actualizar el costo total
    }

    public function updatedSearch(): void
    {
        $this->materials = Material::where('reference', 'like', '%' . $this->search . '%')->get(); // Actualizar materiales según la búsqueda
    }

    public function calculatePartialCost($materialId): void
    {
        if (in_array($materialId, $this->selectedMaterials)) {
            $quantity = $this->quantities[$materialId] ?? 0;
            $efficiencyInput = $this->efficiencyInputs[$materialId] ?? "1"; // Predeterminado a cadena de texto "1"

            $efficiency = DataTypeConverter::convertToFloat($efficiencyInput); // Convertir cadena a número

            if ($efficiency === null) {
                // Establecer el costo parcial en cero si la conversión falla
                $this->partialCosts[$materialId] = 0;
                $this->addError("efficiency_$materialId", "El rendimiento ingresado es inválido.");
                return; // Salir temprano si la conversión falla
            }

            if (is_numeric($quantity)) {
                $material = Material::find($materialId);
                $dailyCost = $material->unit_price;

                // Calcular el costo parcial con la eficiencia convertida
                $partialCost = $quantity * $efficiency * $dailyCost;

                $this->partialCosts[$materialId] = $partialCost;
            } else {
                $this->partialCosts[$materialId] = 0; // Establecer el costo parcial en cero si datos son inválidos
            }
        } else {
            $this->partialCosts[$materialId] = 0; // Si la herramienta no está seleccionada, costo parcial es cero
        }
    }

    public function updatedQuantities($value, $materialId): void
    {
        if (!is_numeric($value)) {
            $this->quantities[$materialId] = null; // Restablecer si no es numérico
            return; // Salir temprano si no es numérico
        }

        // Recalcular el costo parcial y el total
        $this->calculatePartialCost($materialId);
        $this->updateTotalMaterialCost();
    }

    public function updatedEfficiencyInputs($value, $materialId): void
    {
        $efficiency = DataTypeConverter::convertToFloat($value); // Intentar convertir a número

        if ($efficiency === null) {
            // Emitir error si la conversión falla
            $this->addError("efficiency_$materialId", "El valor de rendimiento es inválido.");
            return; // Salir temprano si no es convertible a número
        }

        $this->efficiencies[$materialId] = $efficiency; // Actualizar el valor numérico de la eficiencia
        $this->efficiencyInputs[$materialId] = $value; // Mantener la cadena original para visualización

        // Recalcular el costo parcial y total
        $this->calculatePartialCost($materialId);
        $this->updateTotalMaterialCost();
    }

    public function updateTotalMaterialCost(): void
    {
        // Suma de todos los costos parciales
        $this->totalMaterialCost = array_sum($this->partialCosts);
    }

    public function sendTotalMaterialCost(): void
    {
        $this->dispatch("totalMaterialCostUpdated", $this->totalMaterialCost); // Emitir evento para informar cambios

        // Detalles del componente para el almacenamiento
        $this->dispatch("materialSelectionUpdated", [
            "selectedMaterials" => $this->selectedMaterials,
            "materialQuantities" => $this->quantities,
            "materialEfficiencies" => $this->efficiencies,
            "totalMaterialCost" => $this->totalMaterialCost,
        ]);

        if ($this->totalMaterialCost > 0) {
            $this->dispatch("hideResourceForm"); // Ejemplo de otro evento a despachar
        }
    }

    public function render(): View
    {
        if (!empty($this->search)) {
            $this->materials = Material::where('reference', 'like', '%' . $this->search . '%')->get(); // Actualizar materiales según búsqueda
        }
        return view("livewire.projects.material-selection"); // Renderizar la vista asociada
    }
}
