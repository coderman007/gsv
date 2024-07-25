<?php

namespace App\Livewire\Projects;

use App\Helpers\DataTypeConverter;
use App\Models\Material;
use Illuminate\View\View;
use Livewire\Component;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class MaterialSelectionEdit extends Component
{
    public $availableMaterialsEdit = [];
    public $selectedMaterialsEdit = [];
    public $quantitiesMaterialEdit = [];
    public $efficiencyInputsMaterialEdit = [];
    public $efficienciesMaterialEdit = [];
    public $partialCostsMaterialEdit = [];
    public $totalMaterialCostEdit = 0;
    public $materialSearchEdit = '';
    public $existingSelections = [];

    protected $rules = [
        'selectedMaterialsEdit' => 'required|array|min:1',
        'selectedMaterialsEdit.*' => 'exists:materials,id',
        'quantitiesMaterialEdit.*' => 'nullable|numeric|min:0',
        'efficiencyInputsMaterialEdit.*' => 'nullable|string',
    ];

    /**
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
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
            $this->quantitiesMaterialEdit[$materialId] = $selection['quantity'];
            $this->efficiencyInputsMaterialEdit[$materialId] = $selection['efficiency'];
            $this->efficienciesMaterialEdit[$materialId] = DataTypeConverter::convertToFloat($selection['efficiency']);
            $this->calculatePartialCostMaterialEdit($materialId);
        }

        $this->availableMaterialsEdit = Material::whereIn('id', $this->selectedMaterialsEdit)->get();
    }

    public function updatedSelectedMaterialsEdit(): void
    {
        foreach ($this->availableMaterialsEdit as $material) {
            $materialId = $material->id;
            if (!in_array($materialId, $this->selectedMaterialsEdit)) {
                $this->quantitiesMaterialEdit[$materialId] = null;
                $this->efficiencyInputsMaterialEdit[$materialId] = null;
                $this->efficienciesMaterialEdit[$materialId] = null;
                $this->partialCostsMaterialEdit[$materialId] = 0;
            }
        }
        $this->updateTotalMaterialCostEdit();
    }

    public function addMaterialEdit($materialId): void
    {
        if (!in_array($materialId, $this->selectedMaterialsEdit)) {
            $this->selectedMaterialsEdit[] = $materialId;
        } else {
            // Move the material to the end of the array to ensure it is displayed last
            $this->selectedMaterialsEdit = array_merge(array_diff($this->selectedMaterialsEdit, [$materialId]), [$materialId]);
        }
        $this->materialSearchEdit = '';
        $this->updateTotalMaterialCostEdit();
    }

    public function removeMaterialEdit($materialId): void
    {
        $this->selectedMaterialsEdit = array_diff($this->selectedMaterialsEdit, [$materialId]);
        unset($this->quantitiesMaterialEdit[$materialId]);
        unset($this->efficiencyInputsMaterialEdit[$materialId]);
        unset($this->efficienciesMaterialEdit[$materialId]);
        unset($this->partialCostsMaterialEdit[$materialId]);
        $this->updateTotalMaterialCostEdit();
    }

    public function calculatePartialCostMaterialEdit($materialId): void
    {
        $quantity = $this->quantitiesMaterialEdit[$materialId] ?? 0;
        $efficiencyInput = $this->efficiencyInputsMaterialEdit[$materialId] ?? "1";
        $efficiency = DataTypeConverter::convertToFloat($efficiencyInput);

        if ($efficiency === null) {
            $this->partialCostsMaterialEdit[$materialId] = 0;
            $this->addError("efficiencyInputsMaterialEdit_$materialId", "Entrada de rendimiento inválida: '$efficiencyInput'");
        } else {
            $material = Material::find($materialId);
            $unitPrice = $material->unit_price;
            $this->partialCostsMaterialEdit[$materialId] = $quantity * $efficiency * $unitPrice;
        }

        $this->updateTotalMaterialCostEdit();
    }

    public function updatedQuantitiesMaterialEdit($value, $materialId): void
    {
        if (!is_numeric($value)) {
            $this->quantitiesMaterialEdit[$materialId] = null;
            return;
        }
        $this->calculatePartialCostMaterialEdit($materialId);
        $this->updateTotalMaterialCostEdit();
    }

    public function updatedEfficiencyInputsMaterialEdit($value, $materialId): void
    {
        $efficiency = DataTypeConverter::convertToFloat($value);

        if ($efficiency === null) {
            $this->addError("efficiencyInputsMaterialEdit_$materialId", "Entrada de rendimiento inválida: '$value'");
            return;
        }
        $this->efficienciesMaterialEdit[$materialId] = $efficiency;
        $this->efficiencyInputsMaterialEdit[$materialId] = $value;
        $this->calculatePartialCostMaterialEdit($materialId);
        $this->updateTotalMaterialCostEdit();
    }

    public function updateTotalMaterialCostEdit(): void
    {
        $this->totalMaterialCostEdit = array_sum($this->partialCostsMaterialEdit);
    }

    public function sendTotalMaterialCostEdit(): void
    {
        $this->dispatch('materialSelectionEditUpdated', [
            'selectedMaterialsEdit' => $this->selectedMaterialsEdit,
            'materialQuantitiesEdit' => $this->quantitiesMaterialEdit,
            'materialEfficienciesEdit' => $this->efficienciesMaterialEdit,
            'totalMaterialCostEdit' => $this->totalMaterialCostEdit,
        ]);

        if ($this->totalMaterialCostEdit > 0) {
            $this->dispatch('hideResourceFormEdit');
        }
    }

    public function render(): View
    {
        $filteredMaterials = Material::query()
            ->where('reference', 'like', "%$this->materialSearchEdit%")
            ->get();

        // Reverse the selected materials array to show the last selected at the top
        $selectedMaterials = Material::whereIn('id', $this->selectedMaterialsEdit)->get()->sortByDesc(function ($material) {
            return array_search($material->id, $this->selectedMaterialsEdit);
        });

        return view('livewire.projects.material-selection-edit', [
            'materials' => $filteredMaterials,
            'selectedMaterials' => $selectedMaterials,
        ]);
    }
}
