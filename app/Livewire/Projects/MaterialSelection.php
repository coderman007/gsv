<?php

namespace App\Livewire\Projects;

use App\Helpers\DataTypeConverter;
use App\Models\Material;
use Illuminate\View\View;
use Livewire\Component;

class MaterialSelection extends Component
{
    public $materials = [];
    public $selectedMaterials = [];
    public $quantities = [];
    public $efficiencyInputs = [];
    public $efficiencies = [];
    public $partialCosts = [];
    public $totalMaterialCost = 0;

    public $isEdit = false;
    public $existingSelections = [];

    protected $rules = [
        'selectedMaterials' => 'required|array|min:1',
        'selectedMaterials.*' => 'exists:materials,id',
        'quantities.*' => 'nullable|numeric|min:0',
        'efficiencyInputs.*' => 'nullable|string',
    ];

    public function mount(): void
    {
        $this->materials = Material::all(); // Cargar todos los materiales al montar el componente

        if ($this->isEdit) {
            $this->initializeFromExistingSelections();
        }
        $this->updateTotalMaterialCost();
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
            $this->quantities[$materialId] = null;
            return;
        }

        $this->calculatePartialCost($materialId);
        $this->updateTotalMaterialCost();
    }

    public function updatedEfficiencyInputs($value, $materialId): void
    {
        $efficiency = DataTypeConverter::convertToFloat($value);

        if ($efficiency === null) {
            $this->addError("efficiency_$materialId", "El valor de rendimiento es inválido.");
            return;
        }

        $this->efficiencies[$materialId] = $efficiency;
        $this->efficiencyInputs[$materialId] = $value;

        $this->calculatePartialCost($materialId);
        $this->updateTotalMaterialCost();
    }

    public function updateTotalMaterialCost(): void
    {
        $this->totalMaterialCost = array_sum($this->partialCosts);
    }

    public function sendTotalMaterialCost(): void
    {
        $this->dispatch("totalMaterialCostUpdated", $this->totalMaterialCost);

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
        return view("livewire.projects.material-selection", [
            'materials' => $this->materials,
        ]);
    }
}
