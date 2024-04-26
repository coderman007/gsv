<?php

namespace App\Livewire\Projects;

use App\Models\Tool;
use Illuminate\View\View;
use Livewire\Component;

class ToolSelection extends Component
{
    public $search = '';
    public $tools = [];
    public $selectedTools = [];
    public $quantities = [];
    public $requiredDays = [];
    public $efficiencies = [];
    public $partialToolCosts = [];
    public $totalToolCost = 0;
    public $formattedTotalToolCost;

    protected $rules = [
        'selectedTools' => 'required|array|min:1',
        'selectedTools.*' => 'exists:tools,id',
        'quantities.*' => 'nullable|numeric|min:0',
        'requiredDays.*' => 'nullable|numeric|min:0',
        'efficiencies.*' => ['nullable', 'regex:/^(\d+(\.\d+)?|(\d+\/\d+))$/'],
    ];

    public function updatedSearch(): void
    {
        $this->tools = Tool::where('name', 'like', '%' . $this->search . '%')
            ->get();
    }

    public function updatedQuantities($value, $toolId): void
    {
        if (!is_numeric($value)) {
            $this->quantities[$toolId] = null;
        }

        $this->calculatePartialToolCost();
    }

    public function updatedEfficiencies($value, $toolId): void
    {
        $this->calculatePartialToolCost();
    }

    public function calculatePartialToolCost(): void
    {
        $totalCost = 0;
        foreach ($this->selectedTools as $toolId) {
            $quantity = $this->quantities[$toolId] ?? 0;
            $efficiencyInput = $this->efficiencies[$toolId] ?? "1";

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
                $tool = Tool::find($toolId);
                if ($tool) {
                    $partialCost = $quantity * $efficiency * $tool->unit_price_per_day;
                    $this->partialToolCosts[$toolId] = $partialCost;
                    $totalCost += $partialCost;
                }
            }
        }
        $this->totalToolCost = $totalCost;
        $this->formattedTotalToolCost = number_format($totalCost, 2);
    }
    public function sendTotalToolCost(): void
    {
        $this->dispatch('totalToolCostUpdated', $this->totalToolCost);

        $this->dispatch('toolSelectionUpdated', [
            'selectedTools' => $this->selectedTools,
            'toolQuantities' => $this->quantities,
            'toolRequiredDays' => $this->requiredDays,
            'totalToolCost' => $this->totalToolCost,
        ]);

        if ($this->totalToolCost > 0) {
            $this->dispatch('hideResourceForm');
        }
    }

    public function render(): View
    {
        if (!empty($this->search)) {
            $this->tools = Tool::where('name', 'like', '%' . $this->search . '%')->get();
        }
        return view('livewire.projects.tool-selection');
    }
}
