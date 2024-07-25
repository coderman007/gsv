<?php

namespace App\Livewire\Projects;

use App\Helpers\DataTypeConverter;
use App\Models\Material;
use Illuminate\View\View;
use Livewire\Component;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class MaterialSelectionCreate extends Component
{
    public $availableMaterialsCreate = [];
    public $selectedMaterialsCreate = [];
    public $quantitiesMaterialCreate = [];
    public $efficiencyInputsMaterialCreate = [];
    public $efficienciesMaterialCreate = [];
    public $partialCostsMaterialCreate = [];
    public $totalMaterialCostCreate = 0;
    public $materialSearch = '';

    protected $rules = [
        'selectedMaterialsCreate' => 'required|array|min:1',
        'selectedMaterialsCreate.*' => 'exists:materials,id',
        'quantitiesMaterialCreate.*' => 'nullable|numeric|min:0',
        'efficiencyInputsMaterialCreate.*' => 'nullable|string',
    ];

    /**
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
    public function mount(): void
    {
        $this->availableMaterialsCreate = Material::all();
        $this->updateTotalMaterialCostCreate();

        $this->selectedMaterialsCreate = session()->get('selectedMaterialsCreate', []);
        $this->quantitiesMaterialCreate = session()->get('quantitiesMaterialCreate', []);
        $this->efficiencyInputsMaterialCreate = session()->get('efficiencyInputsMaterialCreate', []);
        $this->efficienciesMaterialCreate = session()->get('efficienciesMaterialCreate', []);
        $this->partialCostsMaterialCreate = session()->get('partialCostsMaterialCreate', []);
        $this->totalMaterialCostCreate = session()->get('totalMaterialCostCreate', 0);
        $this->materialSearch = '';
    }

    public function dehydrate(): void
    {
        session()->put('selectedMaterialsCreate', $this->selectedMaterialsCreate);
        session()->put('quantitiesMaterialCreate', $this->quantitiesMaterialCreate);
        session()->put('efficiencyInputsMaterialCreate', $this->efficiencyInputsMaterialCreate);
        session()->put('efficienciesMaterialCreate', $this->efficienciesMaterialCreate);
        session()->put('partialCostsMaterialCreate', $this->partialCostsMaterialCreate);
        session()->put('totalMaterialCostCreate', $this->totalMaterialCostCreate);
    }

    public function addMaterial($materialId): void
    {
        if (!in_array($materialId, $this->selectedMaterialsCreate)) {
            $this->selectedMaterialsCreate[] = $materialId;
        } else {
            $this->selectedMaterialsCreate = array_merge(array_diff($this->selectedMaterialsCreate, [$materialId]), [$materialId]);
        }
        $this->materialSearch = '';
        $this->updateTotalMaterialCostCreate();
    }

    public function removeMaterial($materialId): void
    {
        $this->selectedMaterialsCreate = array_diff($this->selectedMaterialsCreate, [$materialId]);
        unset($this->quantitiesMaterialCreate[$materialId]);
        unset($this->efficiencyInputsMaterialCreate[$materialId]);
        unset($this->efficienciesMaterialCreate[$materialId]);
        unset($this->partialCostsMaterialCreate[$materialId]);
        $this->updateTotalMaterialCostCreate();
    }

    public function calculatePartialCostCreate($materialId): void
    {
        $quantity = $this->quantitiesMaterialCreate[$materialId] ?? 0;
        $efficiencyInput = $this->efficiencyInputsMaterialCreate[$materialId] ?? "1";
        $efficiency = DataTypeConverter::convertToFloat($efficiencyInput);

        if ($efficiency === null) {
            $this->partialCostsMaterialCreate[$materialId] = 0;
            $this->addError("efficiencyInputsMaterialCreate_$materialId", "Entrada de rendimiento inválida: '$efficiencyInput'");
        } else {
            $material = Material::find($materialId);
            $unitPrice = $material->unit_price;
            $this->partialCostsMaterialCreate[$materialId] = $quantity * $efficiency * $unitPrice;
        }

        $this->updateTotalMaterialCostCreate();
    }

    public function updatedQuantitiesMaterialCreate($value, $materialId): void
    {
        if (!is_numeric($value)) {
            $this->quantitiesMaterialCreate[$materialId] = null;
            return;
        }
        $this->calculatePartialCostCreate($materialId);
        $this->updateTotalMaterialCostCreate();
    }

    public function updatedEfficiencyInputsMaterialCreate($value, $materialId): void
    {
        $efficiency = DataTypeConverter::convertToFloat($value);

        if ($efficiency === null) {
            $this->addError("efficiencyInputsMaterialCreate_$materialId", "Entrada de rendimiento inválida: '$value'");
            return;
        }
        $this->efficienciesMaterialCreate[$materialId] = $efficiency;
        $this->efficiencyInputsMaterialCreate[$materialId] = $value;
        $this->calculatePartialCostCreate($materialId);
        $this->updateTotalMaterialCostCreate();
    }

    public function updateTotalMaterialCostCreate(): void
    {
        $this->totalMaterialCostCreate = array_sum($this->partialCostsMaterialCreate);
    }

    public function sendTotalMaterialCostCreate(): void
    {
        $this->dispatch('materialSelectionCreateUpdated', [
            'selectedMaterialsCreate' => $this->selectedMaterialsCreate,
            'materialQuantitiesCreate' => $this->quantitiesMaterialCreate,
            'materialEfficienciesCreate' => $this->efficienciesMaterialCreate,
            'totalMaterialCostCreate' => $this->totalMaterialCostCreate,
        ]);

        if ($this->totalMaterialCostCreate > 0) {
            $this->dispatch('hideResourceFormCreate');
        }
    }

    public function render(): View
    {
        $filteredMaterials = Material::query()
            ->where('reference', 'like', "%$this->materialSearch%")
            ->get();

        $selectedMaterials = Material::whereIn('id', $this->selectedMaterialsCreate)->get()->sortByDesc(function ($material) {
            return array_search($material->id, $this->selectedMaterialsCreate);
        });

        return view('livewire.projects.material-selection-create', [
            'materials' => $filteredMaterials,
            'selectedMaterials' => $selectedMaterials,
        ]);
    }
}
