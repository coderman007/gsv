<?php

namespace App\Livewire\Projects;

use App\Models\Material;
use Illuminate\View\View;
use Livewire\Component;

class MaterialSelection extends Component
{
    public $search = '';
    public $materials = [];
    public $selectedMaterials = [];
    public $quantities = [];
    public $efficiencies = [];
    public $partialMaterialCosts = [];
    public $totalMaterialCost = 0;
    public $formattedTotalMaterialCost;


    protected $rules = [
        'selectedMaterials' => 'required|array|min:1',
        'selectedMaterials.*' => 'exists:materials,id',
        'quantities.*' => 'nullable|numeric|min:0',
        'efficiencies.*' => ['nullable', 'regex:/^(\d+(\.\d+)?|(\d+\/\d+))$/'],
    ];

    public function updatedSearch(): void
    {
        $this->materials = Material::where('reference', 'like', '%' . $this->search . '%')
            ->orWhere('description', 'like', '%' . $this->search . '%')
            ->get();
    }

    public function updatedQuantities($value, $materialId): void
    {
        if (!is_numeric($value)) {
            $this->quantities[$materialId] = null;
        }

        $this->calculatePartialMaterialCost();
    }

    public function updatedEfficiencies($value, $materialId): void
    {
        $this->calculatePartialMaterialCost();
    }
    public function calculatePartialMaterialCost(): void
    {
        $totalCost = 0;
        foreach ($this->selectedMaterials as $materialId) {
            $quantity = $this->quantities[$materialId] ?? 0;
            $efficiencyInput = $this->efficiencies[$materialId] ?? "1";

            $efficiency = 1.0; // Valor por defecto
            $validEfficiency = false;

            if (str_contains($efficiencyInput, '/')) {
                $parts = explode('/', $efficiencyInput);
                if (count($parts) == 2) {
                    $numerator = floatval($parts[0]);
                    $denominator = floatval($parts[1]);
                    if ($denominator != 0) {
                        $efficiency = $numerator / $denominator;
                        $validEfficiency = true;
                    }
                }
            } else {
                $validEfficiency = is_numeric($efficiencyInput);
                if ($validEfficiency) {
                    $efficiency = floatval($efficiencyInput);
                }
            }

            if ($validEfficiency && is_numeric($quantity)) {
                $material = Material::find($materialId);
                if ($material) {
                    $partialCost = $quantity * $efficiency * $material->unit_price;
                    $this->partialMaterialCosts[$materialId] = $partialCost;
                    $totalCost += $partialCost;
                }
            }
        }
        $this->totalMaterialCost = $totalCost;
        $this->formattedTotalMaterialCost = number_format($totalCost, 2);
    }

    public function sendTotalMaterialCost(): void
    {
        $this->dispatch('totalMaterialCostUpdated', $this->totalMaterialCost);
        $this->dispatch('materialSelectionUpdated', [
            'selectedMaterials' => $this->selectedMaterials,
            'materialQuantities' => $this->quantities,
            'totalMaterialCost' => $this->totalMaterialCost,
        ]);

        if ($this->totalMaterialCost > 0) {
            $this->dispatch('hideResourceForm');
        }
    }

    public function render(): View
    {
        if (!empty($this->search)) {
            $this->materials = Material::where('reference', 'like', '%' . $this->search . '%')
                ->orWhere('description', 'like', '%' . $this->search . '%')
                ->get();
        }
        return view('livewire.projects.material-selection');
    }
}
