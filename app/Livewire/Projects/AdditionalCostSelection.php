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
    public $totalAdditionalCost = 0;
    public $formattedTotalAdditionalCost;

    protected $rules = [
        'selectedAdditionalCosts' => 'required|array|min:1',
        'selectedAdditionalCosts.*' => 'exists:additional_costs,id',
        'quantities.*' => 'nullable|numeric|min:0',
    ];

    public function updatedSearch(): void
    {
        $this->additionalCosts = AdditionalCost::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('description', 'like', '%' . $this->search . '%')
            ->get();
    }

    public function updatedQuantities($value, $additionalCostId): void
    {
        // Si el valor no es numérico, establece el valor como null
        if (!is_numeric($value)) {
            $this->quantities[$additionalCostId] = null;
        }

        $this->calculateTotalAdditionalCost();
    }

    public function calculateTotalAdditionalCost(): void
    {
        $totalCost = 0;
        foreach ($this->selectedAdditionalCosts as $additionalCostId) {
            $quantity = $this->quantities[$additionalCostId] ?? 0;
            if (is_numeric($quantity)) {
                $additionalCost = AdditionalCost::find($additionalCostId);
                if ($additionalCost) {
                    $totalCost += $quantity * $additionalCost->amount;
                }
            }
        }
        $this->totalAdditionalCost = $totalCost;
        $this->formattedTotalAdditionalCost = number_format($totalCost, 2);
    }

    public function sendTotalAdditionalCost(): void
    {
        $this->dispatch('totalAdditionalCostUpdated', $this->totalAdditionalCost);

        $this->dispatch('additionalCostSelectionUpdated', [
            'selectedAdditionalCosts' => $this->selectedAdditionalCosts,
            'additionalCostQuantities' => $this->quantities,
            'totalAdditionalCost' => $this->totalAdditionalCost,
        ]);

        if ($this->totalAdditionalCost > 0) {
            $this->dispatch('hideResourceForm');
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
