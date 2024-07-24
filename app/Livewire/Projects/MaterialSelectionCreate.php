<?php

namespace App\Livewire\Projects;

use App\Helpers\DataTypeConverter;
use App\Models\Material;
use Illuminate\View\View;
use Livewire\Component;

class MaterialSelectionCreate extends Component
{
    public $availableMaterialsCreate = [];
    public $selectedMaterialsCreate = [];
    public $quantitiesCreate = [];
    public $efficiencyInputsCreate = [];
    public $efficienciesCreate = [];
    public $partialCostsCreate = [];
    public $totalMaterialCostCreate = 0;
    public $search = '';

    protected $rules = [
        'selectedMaterialsCreate' => 'required|array|min:1',
        'selectedMaterialsCreate.*' => 'exists:materials,id',
        'quantitiesCreate.*' => 'nullable|numeric|min:0',
        'efficiencyInputsCreate.*' => 'nullable|string',
    ];

    public function mount(): void
    {
        $this->availableMaterialsCreate = Material::all();
        $this->updateTotalMaterialCostCreate();

        $this->selectedMaterialsCreate = session()->get('selectedMaterialsCreate', []);
        $this->quantitiesCreate = session()->get('quantitiesCreate', []);
        $this->efficiencyInputsCreate = session()->get('efficiencyInputsCreate', []);
        $this->efficienciesCreate = session()->get('efficienciesCreate', []);
        $this->partialCostsCreate = session()->get('partialCostsCreate', []);
        $this->totalMaterialCostCreate = session()->get('totalMaterialCostCreate', 0);
        $this->search = '';
    }

    public function dehydrate(): void
    {
        session()->put('selectedMaterialsCreate', $this->selectedMaterialsCreate);
        session()->put('quantitiesCreate', $this->quantitiesCreate);
        session()->put('efficiencyInputsCreate', $this->efficiencyInputsCreate);
        session()->put('efficienciesCreate', $this->efficienciesCreate);
        session()->put('partialCostsCreate', $this->partialCostsCreate);
        session()->put('totalMaterialCostCreate', $this->totalMaterialCostCreate);
    }

    public function addMaterial($materialId): void
    {
        if (!in_array($materialId, $this->selectedMaterialsCreate)) {
            $this->selectedMaterialsCreate[] = $materialId;
        } else {
            // Move the material to the end of the array to ensure it is displayed last
            $this->selectedMaterialsCreate = array_merge(array_diff($this->selectedMaterialsCreate, [$materialId]), [$materialId]);
        }
        $this->search = '';
        $this->updateTotalMaterialCostCreate();
    }

    public function removeMaterial($materialId): void
    {
        $this->selectedMaterialsCreate = array_diff($this->selectedMaterialsCreate, [$materialId]);
        unset($this->quantitiesCreate[$materialId]);
        unset($this->efficiencyInputsCreate[$materialId]);
        unset($this->efficienciesCreate[$materialId]);
        unset($this->partialCostsCreate[$materialId]);
        $this->updateTotalMaterialCostCreate();
    }

    public function calculatePartialCostCreate($materialId): void
    {
        $quantity = $this->quantitiesCreate[$materialId] ?? 0;
        $efficiencyInput = $this->efficiencyInputsCreate[$materialId] ?? "1";
        $efficiency = DataTypeConverter::convertToFloat($efficiencyInput);

        if ($efficiency === null) {
            $this->partialCostsCreate[$materialId] = 0;
            $this->addError("efficiencyInputsCreate_$materialId", "Entrada de rendimiento inválida: '$efficiencyInput'");
        } else {
            $material = Material::find($materialId);
            $unitPrice = $material->unit_price;
            $this->partialCostsCreate[$materialId] = $quantity * $efficiency * $unitPrice;
        }

        $this->updateTotalMaterialCostCreate();
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
            $this->addError("efficiencyInputsCreate_$materialId", "Entrada de rendimiento inválida: '$value'");
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
        $this->dispatch('materialSelectionCreateUpdated', [
            'selectedMaterialsCreate' => $this->selectedMaterialsCreate,
            'materialQuantitiesCreate' => $this->quantitiesCreate,
            'materialEfficienciesCreate' => $this->efficienciesCreate,
            'totalMaterialCostCreate' => $this->totalMaterialCostCreate,
        ]);

        if ($this->totalMaterialCostCreate > 0) {
            $this->dispatch('hideResourceFormCreate');
        }
    }

    public function render(): View
    {
        $filteredMaterials = Material::query()
            ->where('reference', 'like', "%{$this->search}%")
            ->get();

        // Reverse the selected materials array to show the last selected at the top
        $selectedMaterials = Material::whereIn('id', $this->selectedMaterialsCreate)->get()->sortByDesc(function ($material) {
            return array_search($material->id, $this->selectedMaterialsCreate);
        });

        return view('livewire.projects.material-selection-create', [
            'materials' => $filteredMaterials,
            'selectedMaterials' => $selectedMaterials,
        ]);
    }
}
