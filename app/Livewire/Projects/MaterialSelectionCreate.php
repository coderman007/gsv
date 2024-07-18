<?php

namespace App\Livewire\Projects;

use App\Helpers\DataTypeConverter;
use App\Models\Material;
use Illuminate\View\View;
use Livewire\Component;

class MaterialSelectionCreate extends Component
{
    public $search = '';
    public $materials = [];
    public $selectedMaterialsCreate = [];
    public $quantitiesCreate = [];
    public $efficiencyInputsCreate = [];
    public $efficienciesCreate = [];
    public $partialCostsCreate = [];
    public $totalMaterialCostCreate = 0;

    protected $rules = [
        'selectedMaterialsCreate' => 'required|array|min:1',
        'selectedMaterialsCreate.*' => 'exists:materials,id',
        'quantitiesCreate.*' => 'nullable|numeric|min:0',
        'efficiencyInputsCreate.*' => 'nullable|string',
    ];

    public function mount(): void
    {
        $this->updateTotalMaterialCostCreate();
    }

    public function updatedSearch(): void
    {
        $this->materials = Material::where('reference', 'like', '%' . $this->search . '%')->get();
    }

    public function updatedSelectedMaterialsCreate(): void
    {
        foreach ($this->materials as $material) {
            $materialId = $material->id;
            if (!in_array($materialId, $this->selectedMaterialsCreate)) {
                $this->quantitiesCreate[$materialId] = null;
                $this->efficiencyInputsCreate[$materialId] = null;
                $this->efficienciesCreate[$materialId] = null;
                $this->partialCostsCreate[$materialId] = 0;
            }
        }
        $this->updateTotalMaterialCostCreate();
    }

    public function calculatePartialCostCreate($materialId): void
    {
        if (in_array($materialId, $this->selectedMaterialsCreate)) {
            $quantity = $this->quantitiesCreate[$materialId] ?? 0;
            $efficiencyInput = $this->efficiencyInputsCreate[$materialId] ?? "1";
            $efficiency = DataTypeConverter::convertToFloat($efficiencyInput);

            if ($efficiency === null) {
                $this->partialCostsCreate[$materialId] = 0;
                $this->addError("efficiencyInputsCreate_$materialId", "El rendimiento ingresado es inválido.");
                return;
            }

            if (is_numeric($quantity)) {
                $material = Material::find($materialId);
                $unitPrice = $material->unit_price;
                $partialCost = $quantity * $efficiency * $unitPrice;
                $this->partialCostsCreate[$materialId] = $partialCost;
            } else {
                $this->partialCostsCreate[$materialId] = 0;
            }
        } else {
            $this->partialCostsCreate[$materialId] = 0;
        }
    }

    public function updatedQuantitiesCreate($value, $materialId): void
    {
        if (!is_numeric($value)) {
            $this->quantitiesCreate[$materialId] = null;
            return;
        }
        $this->calculatePartialCostCreate($materialId);
        $this->updateTotalMaterialCostCreate();
    }

    public function updatedEfficiencyInputsCreate($value, $materialId): void
    {
        $efficiency = DataTypeConverter::convertToFloat($value);
        if ($efficiency === null) {
            $this->addError("efficiencyInputsCreate_$materialId", "El valor de rendimiento es inválido.");
            return;
        }
        $this->efficienciesCreate[$materialId] = $efficiency;
        $this->efficiencyInputsCreate[$materialId] = $value;
        $this->calculatePartialCostCreate($materialId);
        $this->updateTotalMaterialCostCreate();
    }

    public function updateTotalMaterialCostCreate(): void
    {
        $this->totalMaterialCostCreate = array_sum($this->partialCostsCreate);
    }

    public function sendTotalMaterialCostCreate(): void
    {
        $this->dispatch("totalMaterialCostCreateUpdated", $this->totalMaterialCostCreate);
        $this->dispatch("materialSelectionCreateUpdated", [
            "selectedMaterialsCreate" => $this->selectedMaterialsCreate,
            "materialQuantitiesCreate" => $this->quantitiesCreate,
            "materialEfficienciesCreate" => $this->efficienciesCreate,
            "totalMaterialCostCreate" => $this->totalMaterialCostCreate,
        ]);

        if ($this->totalMaterialCostCreate > 0) {
            $this->dispatch("hideResourceFormCreate");
        }
    }

    public function render(): View
    {
        if (!empty($this->search)) {
            $this->materials = Material::where('reference', 'like', '%' . $this->search . '%')->get();
        }
        return view("livewire.projects.material-selection-create", [
            'materials' => $this->materials,
        ]);
    }
}

