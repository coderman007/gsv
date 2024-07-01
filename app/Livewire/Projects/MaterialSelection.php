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

    public $isEdit = false;
    public $existingSelections = [];

    protected $rules = [
        'selectedMaterials' => 'required|array|min:1',
        'selectedMaterials.*' => 'exists:materials,id',
        'quantities.*' => 'nullable|numeric|min:0',
        'efficiencyInputs.*' => 'nullable|string', // Aceptamos cadenas de texto para rendimiento
    ];

    public function mount(): void
    {
        if ($this->isEdit) {
            $this->initializeFromExistingSelections();
        }
        $this->updateTotalMaterialCost(); // Actualizar el costo total
    }

    public function initializeFromExistingSelections(): void
    {
        foreach ($this->existingSelections as $selection) {
            $materialId = $selection['material_id'];
            $this->selectedMaterials[] = $materialId;
            $this->quantities[$materialId] = $selection['quantity'];
            $this->efficiencyInputs[$materialId] = $selection['efficiency'];
            $this->efficiencies[$materialId] = DataTypeConverter::convertToFloat($selection['efficiency']);
            $this->calculatePartialCost($materialId);
        }

        // Cargar todos los materiales seleccionados en la búsqueda inicial
        $this->materials = Material::whereIn('id', $this->selectedMaterials)->get();
    }

    public function updatedSearch(): void
    {
        $this->materials = Material::where('reference', 'like', '%' . $this->search . '%')->get(); // Actualizar materiales según la búsqueda
    }

    public function updatedSelectedMaterials(): void
    {
        foreach ($this->materials as $material) {
            $materialId = $material->id;
            if (!in_array($materialId, $this->selectedMaterials)) {
                // Restablecer los campos si el material no está seleccionado
                $this->quantities[$materialId] = null;
                $this->efficiencyInputs[$materialId] = null;
                $this->efficiencies[$materialId] = null;
                $this->partialCosts[$materialId] = 0;
            }
        }
        $this->updateTotalMaterialCost();
    }

    public function calculatePartialCost($materialId): void
    {
        if (in_array($materialId, $this->selectedMaterials)) {
            $quantity = $this->quantities[$materialId] ?? 0;
            $efficiencyInput = $this->efficiencyInputs[$materialId] ?? "1";
            $efficiency = DataTypeConverter::convertToFloat($efficiencyInput);

            if ($efficiency === null) {
                $this->partialCosts[$materialId] = 0;
                $this->addError("efficiency_$materialId", "El rendimiento ingresado es inválido.");
                return;
            }

            if (is_numeric($quantity)) {
                $material = Material::find($materialId);
                $unitPrice = $material->unit_price;

                $partialCost = $quantity * $efficiency * $unitPrice;

                $this->partialCosts[$materialId] = $partialCost;
            } else {
                $this->partialCosts[$materialId] = 0;
            }
        } else {
            $this->partialCosts[$materialId] = 0;
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
            $this->dispatch("hideResourceForm");
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
