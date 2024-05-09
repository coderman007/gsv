<?php

namespace App\Livewire\Projects;

use App\Models\AdditionalCost;
use Illuminate\View\View;
use Livewire\Component;

class AdditionalCostSelection extends Component
{
    public $search = '';
    public $additionalCosts = [];
    public $selectedAdditionalCosts = [];
    public $quantities = [];
    public $efficiencies = [];
    public $partialCosts = [];
    public $totalAdditionalCost = 0;

    protected $rules = [
        'selectedAdditionalCosts' => 'required|array|min:1',
        'selectedAdditionalCosts.*' => 'exists:additional_costs,id',
        'quantities.*' => 'nullable|numeric|min:0',
        'efficiencies.*' => ['nullable', 'regex:/^(\d+(\.\d+)?|(\d+\/\d+))$/'],
    ];

    public function updatedSearch(): void
    {
        $this->additionalCosts = AdditionalCost::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('description', 'like', '%' . $this->search . '%')
            ->get();
    }

    public function updatedQuantities($value, $costId): void
    {
        if (!is_numeric($value)) {
            $this->quantities[$costId] = null;
        }

        $this->calculatePartialCosts();
    }

    public function updatedEfficiencies($value, $costId): void
    {
        $this->calculatePartialCosts();
    }

    public function calculatePartialCosts(): void
    {
        $totalAdditionalCost = 0;
        foreach ($this->selectedAdditionalCosts as $costId) {
            $quantity = $this->quantities[$costId] ?? 0;
            $efficiencyInput = $this->efficiencies[$costId] ?? "1";

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
                $additionalCost = AdditionalCost::find($costId);
                if ($additionalCost) {
                    $partialCost = $quantity * $efficiency * $additionalCost->unit_price;
                    $this->partialCosts[$costId] = $partialCost;
                    $totalAdditionalCost += $partialCost;
                }
            }
        }
        $this->totalAdditionalCost = $totalAdditionalCost;
    }

    public function sendTotalCost(): void
    {
        $this->dispatch('totalAdditionalCostUpdated', $this->totalAdditionalCost);
        $this->dispatch('additionalCostSelectionUpdated', [
            'selectedAdditionalCosts' => $this->selectedAdditionalCosts,
            'additionalCostQuantities' => $this->quantities,
            'totalAdditionalCost' => $this->totalAdditionalCost,
        ]);

        if ($this->totalAdditionalCost > 0) {
            $this->dispatch('hideAdditionalCostForm');
        }
    }

    public function render(): View
    {
        if (!empty($this->search)) {
            $this->additionalCosts = AdditionalCost::where('name', 'like', '%' . $this->search . '%')
                ->orWhere('description', 'like', '%' . $this->search . '%')
                ->get();
        }
        return view('livewire.projects.additional-cost-selection');
    }
}
