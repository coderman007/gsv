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
    public $totalMaterialCost = 0;
    public $formattedTotalMaterialCost;

    protected $rules = [
        'selectedMaterials' => 'required|array|min:1',
        'selectedMaterials.*' => 'exists:materials,id',
        'quantities.*' => 'nullable|numeric|min:0',
    ];

    public function updatedSearch(): void
    {
        $this->materials = Material::where('reference', 'like', '%' . $this->search . '%')
            ->orWhere('description', 'like', '%' . $this->search . '%')
            ->get();
    }

    public function updatedQuantities($value, $materialId): void
    {
        // Si el valor no es numérico, establece el valor como null
        if (!is_numeric($value)) {
            $this->quantities[$materialId] = null;
        }

        $this->calculateTotalMaterialCost();
    }

    public function calculateTotalMaterialCost(): void
    {
        $totalCost = 0;
        foreach ($this->selectedMaterials as $materialId) {
            $quantity = $this->quantities[$materialId] ?? 0;
            if (is_numeric($quantity)) {
                $material = Material::find($materialId);
                if ($material) {
                    $totalCost += $quantity * $material->unit_price;
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
