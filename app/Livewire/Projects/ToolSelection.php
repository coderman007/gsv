<?php

namespace App\Livewire\Projects;

use App\Helpers\DataTypeConverter;
use App\Models\Tool;
use Illuminate\View\View;
use Livewire\Component;

class ToolSelection extends Component
{
    public $tools = [];
    public $selectedTools = [];
    public $quantities = [];
    public $requiredDays = [];
    public $efficiencyInputs = [];
    public $efficiencies = [];
    public $partialCosts = [];
    public $extraHandToolCost = 0;
    public $totalToolCost = 0;

    public $isEdit = false;
    public $existingSelections = [];

    protected $rules = [
        'selectedTools' => 'required|array|min:1',
        'selectedTools.*' => 'exists:tools,id',
        'quantities.*' => 'nullable|numeric|min:0',
        'requiredDays.*' => 'nullable|numeric|min:0',
        'efficiencyInputs.*' => 'nullable|string',
    ];

    public function mount(): void
    {
        $this->tools = Tool::all(); // Cargar todas las herramientas al montar el componente

        if ($this->isEdit) {
            $this->initializeFromExistingSelections();
        }
        $this->updateTotalToolCost();
    }

    public function initializeFromExistingSelections(): void
    {
        foreach ($this->existingSelections as $selection) {
            $toolId = $selection['tool_id'];
            $this->selectedTools[] = $toolId;
            $this->quantities[$toolId] = $selection['quantity'];
            $this->requiredDays[$toolId] = $selection['required_days'];
            $this->efficiencyInputs[$toolId] = $selection['efficiency'];
            $this->efficiencies[$toolId] = DataTypeConverter::convertToFloat($selection['efficiency']);
            $this->calculatePartialCost($toolId);
        }
    }

    public function calculatePartialCost($toolId): void
    {
        if (in_array($toolId, $this->selectedTools)) {
            $quantity = $this->quantities[$toolId] ?? 0;
            $requiredDays = $this->requiredDays[$toolId] ?? 0;
            $efficiencyInput = $this->efficiencyInputs[$toolId] ?? "1";

            $efficiency = DataTypeConverter::convertToFloat($efficiencyInput);

            if ($efficiency === null) {
                $this->partialCosts[$toolId] = 0;
                $this->addError("efficiency_$toolId", "El rendimiento ingresado es inválido.");
                return;
            }

            if (is_numeric($quantity) && is_numeric($requiredDays)) {
                $tool = Tool::find($toolId);
                $dailyCost = $tool->unit_price_per_day;
                $partialCost = $quantity * $requiredDays * $efficiency * $dailyCost;
                $partialCost += $this->extraHandToolCost;

                $this->partialCosts[$toolId] = $partialCost;
            } else {
                $this->partialCosts[$toolId] = 0;
            }
        } else {
            $this->partialCosts[$toolId] = 0;
        }
    }

    public function updatedQuantities($value, $toolId): void
    {
        if (!is_numeric($value)) {
            $this->quantities[$toolId] = null;
            return;
        }

        $this->calculatePartialCost($toolId);
        $this->updateTotalToolCost();
    }

    public function updatedRequiredDays($value, $toolId): void
    {
        if (!is_numeric($value)) {
            $this->requiredDays[$toolId] = null;
            return;
        }

        $this->calculatePartialCost($toolId);
        $this->updateTotalToolCost();
    }

    public function updatedEfficiencyInputs($value, $toolId): void
    {
        $efficiency = DataTypeConverter::convertToFloat($value);

        if ($efficiency === null) {
            $this->addError("efficiency_$toolId", "El valor de rendimiento es inválido.");
            return;
        }

        $this->efficiencies[$toolId] = $efficiency;
        $this->efficiencyInputs[$toolId] = $value;

        $this->calculatePartialCost($toolId);
        $this->updateTotalToolCost();
    }

    public function updateTotalToolCost(): void
    {
        $this->totalToolCost = array_sum($this->partialCosts);
    }

    public function sendTotalToolCost(): void
    {
        $this->dispatch("totalToolCostUpdated", $this->totalToolCost);

        $this->dispatch("toolSelectionUpdated", [
            "selectedTools" => $this->selectedTools,
            "toolQuantities" => $this->quantities,
            "toolRequiredDays" => $this->requiredDays,
            "toolEfficiencies" => $this->efficiencies,
            "totalToolCost" => $this->totalToolCost,
        ]);

        if ($this->totalToolCost > 0) {
            $this->dispatch("hideResourceForm");
        }
    }

    public function render(): View
    {
        return view("livewire.projects.tool-selection", [
            'tools' => $this->tools,
        ]);
    }
}
