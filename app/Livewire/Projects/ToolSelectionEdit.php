<?php

namespace App\Livewire\Projects;

use App\Helpers\DataTypeConverter;
use App\Models\Tool;
use Illuminate\View\View;
use Livewire\Component;

class ToolSelectionEdit extends Component
{
    public $search = '';
    public $tools = [];
    public $selectedToolsEdit = [];
    public $quantitiesEdit = [];
    public $requiredDaysEdit = [];
    public $efficiencyInputsEdit = [];
    public $efficienciesEdit = [];
    public $partialCostsEdit = [];
    public $totalToolCostEdit = 0;

    public $existingSelections = [];

    protected $rules = [
        'selectedToolsEdit' => 'required|array|min:1',
        'selectedToolsEdit.*' => 'exists:tools,id',
        'quantitiesEdit.*' => 'nullable|numeric|min:0',
        'requiredDaysEdit.*' => 'nullable|numeric|min:0',
        'efficiencyInputsEdit.*' => 'nullable|string',
    ];

    public function mount(): void
    {
        $this->initializeFromExistingSelections();
        $this->updateTotalToolCostEdit();
    }

    public function initializeFromExistingSelections(): void
    {
        foreach ($this->existingSelections as $selection) {
            $toolId = $selection['tool_id'];
            $this->selectedToolsEdit[] = $toolId;
            $this->quantitiesEdit[$toolId] = $selection['quantity'];
            $this->requiredDaysEdit[$toolId] = $selection['required_days'];
            $this->efficiencyInputsEdit[$toolId] = $selection['efficiency'];
            $this->efficienciesEdit[$toolId] = DataTypeConverter::convertToFloat($selection['efficiency']);
            $this->calculatePartialCostEdit($toolId);
        }

        $this->tools = Tool::whereIn('id', $this->selectedToolsEdit)->get();
    }

    public function updatedSearch(): void
    {
        $this->tools = Tool::where('name', 'like', '%' . $this->search . '%')->get();
    }

    public function updatedSelectedToolsEdit(): void
    {
        foreach ($this->tools as $tool) {
            $toolId = $tool->id;
            if (!in_array($toolId, $this->selectedToolsEdit)) {
                $this->quantitiesEdit[$toolId] = null;
                $this->requiredDaysEdit[$toolId] = null;
                $this->efficiencyInputsEdit[$toolId] = null;
                $this->efficienciesEdit[$toolId] = null;
                $this->partialCostsEdit[$toolId] = 0;
            }
        }
        $this->updateTotalToolCostEdit();
    }

    public function calculatePartialCostEdit($toolId): void
    {
        if (in_array($toolId, $this->selectedToolsEdit)) {
            $quantity = $this->quantitiesEdit[$toolId] ?? 0;
            $requiredDays = $this->requiredDaysEdit[$toolId] ?? 0;
            $efficiencyInput = $this->efficiencyInputsEdit[$toolId] ?? "1";
            $efficiency = DataTypeConverter::convertToFloat($efficiencyInput);

            if ($efficiency === null) {
                $this->partialCostsEdit[$toolId] = 0;
                $this->addError("efficiencyInputsEdit_$toolId", "El rendimiento ingresado es inválido.");
                return;
            }

            if (is_numeric($quantity) && is_numeric($requiredDays)) {
                $tool = Tool::find($toolId);
                $dailyCost = $tool->unit_price_per_day;
                $partialCost = $quantity * $requiredDays * $efficiency * $dailyCost;
                $this->partialCostsEdit[$toolId] = $partialCost;
            } else {
                $this->partialCostsEdit[$toolId] = 0;
            }
        } else {
            $this->partialCostsEdit[$toolId] = 0;
        }
    }

    public function updatedQuantitiesEdit($value, $toolId): void
    {
        if (!is_numeric($value)) {
            $this->quantitiesEdit[$toolId] = null;
            return;
        }

        $this->calculatePartialCostEdit($toolId);
        $this->updateTotalToolCostEdit();
    }

    public function updatedRequiredDaysEdit($value, $toolId): void
    {
        if (!is_numeric($value)) {
            $this->requiredDaysEdit[$toolId] = null;
            return;
        }

        $this->calculatePartialCostEdit($toolId);
        $this->updateTotalToolCostEdit();
    }

    public function updatedEfficiencyInputsEdit($value, $toolId): void
    {
        $efficiency = DataTypeConverter::convertToFloat($value);

        if ($efficiency === null) {
            $this->addError("efficiencyInputsEdit_$toolId", "El valor de rendimiento es inválido.");
            return;
        }

        $this->efficienciesEdit[$toolId] = $efficiency;
        $this->efficiencyInputsEdit[$toolId] = $value;
        $this->calculatePartialCostEdit($toolId);
        $this->updateTotalToolCostEdit();
    }

    public function updateTotalToolCostEdit(): void
    {
        $this->totalToolCostEdit = array_sum($this->partialCostsEdit);
    }

    public function sendTotalToolCostEdit(): void
    {
        $this->dispatch("totalToolCostEditUpdated", $this->totalToolCostEdit);
        $this->dispatch("toolSelectionEditUpdated", [
            "selectedToolsEdit" => $this->selectedToolsEdit,
            "toolQuantitiesEdit" => $this->quantitiesEdit,
            "toolRequiredDaysEdit" => $this->requiredDaysEdit,
            "toolEfficienciesEdit" => $this->efficienciesEdit,
            "totalToolCostEdit" => $this->totalToolCostEdit,
        ]);

        if ($this->totalToolCostEdit > 0) {
            $this->dispatch("hideResourceFormEdit");
        }
    }

    public function render(): View
    {
        if (!empty($this->search)) {
            $this->tools = Tool::where('name', 'like', '%' . $this->search . '%')->get();
        }
        return view("livewire.projects.tool-selection-edit", [
            'tools' => $this->tools,
        ]);
    }
}

