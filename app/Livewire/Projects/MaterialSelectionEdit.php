<?php

namespace App\Livewire\Projects;

use App\Helpers\DataTypeConverter;
use App\Models\Material;
use Illuminate\View\View;
use Livewire\Component;

class MaterialSelectionEdit extends Component
{
    public $search = '';
    public $materials = [];
    public $selectedMaterialsEdit = [];
    public $quantitiesEdit = [];
    public $efficiencyInputsEdit = [];
    public $efficienciesEdit = [];
    public $partialCostsEdit = [];
    public $totalMaterialCostEdit = 0;

    public $existingSelections = [];

    protected $rules = [
        'selectedMaterialsEdit' => 'required|array|min:1',
        'selectedMaterialsEdit.*' => 'exists:materials,id',
        'quantitiesEdit.*' => 'nullable|numeric|min:0',
        'efficiencyInputsEdit.*' => 'nullable|string',
    ];

    public function mount(): void
    {
        $this->initializeFromExistingSelections();
        $this->updateTotalMaterialCostEdit();
    }

    public function initializeFromExistingSelections(): void
    {
        foreach ($this->existingSelections as $selection) {
            $materialId = $selection['material_id'];
            $this->selectedMaterialsEdit[] = $materialId;
            $this->quantitiesEdit[$materialId] = $selection['quantity'];
            $this->efficiencyInputsEdit[$materialId] = $selection['efficiency'];
            $this->efficienciesEdit[$materialId] = DataTypeConverter::convertToFloat($selection['efficiency']);
            $this->calculatePartialCostEdit($materialId);
        }

        $this->materials = Material::whereIn('id', $this->selectedMaterialsEdit)->get();
    }

    public function updatedSearch(): void
    {
        $this->materials = Material::where('reference', 'like', '%' . $this->search . '%')->get();
    }

    public function updatedSelectedMaterialsEdit(): void
    {
        foreach ($this->materials as $material) {
            $materialId = $material->id;
            if (!in_array($materialId, $this->selectedMaterialsEdit)) {
                $this->quantitiesEdit[$materialId] = null;
                $this->efficiencyInputsEdit[$materialId] = null;
                $this->efficienciesEdit[$materialId] = null;
                $this->partialCostsEdit[$materialId] = 0;
            }
        }
        $this->updateTotalMaterialCostEdit();
    }

    public function calculatePartialCostEdit($materialId): void
    {
        if (in_array($materialId, $this->selectedMaterialsEdit)) {
            $quantity = $this->quantitiesEdit[$materialId] ?? 0;
            $efficiencyInput = $this->efficiencyInputsEdit[$materialId] ?? "1";
            $efficiency = DataTypeConverter::convertToFloat($efficiencyInput);

            if ($efficiency === null) {
                $this->partialCostsEdit[$materialId] = 0;
                $this->addError("efficiencyInputsEdit_$materialId", "El rendimiento ingresado es inválido.");
                return;
            }

            if (is_numeric($quantity)) {
                $material = Material::find($materialId);
                $unitPrice = $material->unit_price;
                $partialCost = $quantity * $efficiency * $unitPrice;
                $this->partialCostsEdit[$materialId] = $partialCost;
            } else {
                $this->partialCostsEdit[$materialId] = 0;
            }
        } else {
            $this->partialCostsEdit[$materialId] = 0;
        }
    }

    public function updatedQuantitiesEdit($value, $materialId): void
    {
        if (!is_numeric($value)) {
            $this->quantitiesEdit[$materialId] = null;
            return;
        }
        $this->calculatePartialCostEdit($materialId);
        $this->updateTotalMaterialCostEdit();
    }

    public function updatedEfficiencyInputsEdit($value, $materialId): void
    {
        $efficiency = DataTypeConverter::convertToFloat($value);
        if ($efficiency === null) {
            $this->addError("efficiencyInputsEdit_$materialId", "El valor de rendimiento es inválido.");
            return;
        }
        $this->efficienciesEdit[$materialId] = $efficiency;
        $this->efficiencyInputsEdit[$materialId] = $value;
        $this->calculatePartialCostEdit($materialId);
        $this->updateTotalMaterialCostEdit();
    }

    public function updateTotalMaterialCostEdit(): void
    {
        $this->totalMaterialCostEdit = array_sum($this->partialCostsEdit);
    }

    public function sendTotalMaterialCostEdit(): void
    {
        $this->dispatch("totalMaterialCostEditUpdated", $this->totalMaterialCostEdit);
        $this->dispatch("materialSelectionEditUpdated", [
            "selectedMaterialsEdit" => $this->selectedMaterialsEdit,
            "materialQuantitiesEdit" => $this->quantitiesEdit,
            "materialEfficienciesEdit" => $this->efficienciesEdit,
            "totalMaterialCostEdit" => $this->totalMaterialCostEdit,
        ]);

        if ($this->totalMaterialCostEdit > 0) {
            $this->dispatch("hideResourceFormEdit");
        }
    }

    public function render(): View
    {
        if (!empty($this->search)) {
            $this->materials = Material::where('reference', 'like', '%' . $this->search . '%')->get();
        }
        return view("livewire.projects.material-selection-edit", [
            'materials' => $this->materials,
        ]);
    }
}
