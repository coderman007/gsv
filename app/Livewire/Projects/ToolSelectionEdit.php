<?php

namespace App\Livewire\Projects;

use App\Helpers\DataTypeConverter;
use App\Models\Tool;
use Illuminate\View\View;
use Livewire\Component;

class ToolSelectionEdit extends Component
{
    public $availableToolsEdit = [];
    public $selectedToolsEdit = [];
    public $quantitiesToolEdit = [];
    public $requiredDaysToolEdit = [];
    public $efficiencyInputsToolEdit = [];
    public $efficienciesToolEdit = [];
    public $partialCostsToolEdit = [];
    public $totalToolCostEdit = 0;
    public $toolSearchEdit = '';
    public $existingSelections = [];

    protected $rules = [
        'selectedToolsEdit' => 'required|array|min:1',
        'selectedToolsEdit.*' => 'exists:tools,id',
        'quantitiesToolEdit.*' => 'nullable|numeric|min:0',
        'requiredDaysToolEdit.*' => 'nullable|numeric|min:0',
        'efficiencyInputsToolEdit.*' => 'nullable|string',
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
            $this->quantitiesToolEdit[$toolId] = $selection['quantity'];
            $this->requiredDaysToolEdit[$toolId] = $selection['required_days'];
            $this->efficiencyInputsToolEdit[$toolId] = $selection['efficiency'];
            $this->efficienciesToolEdit[$toolId] = DataTypeConverter::convertToFloat($selection['efficiency']);
            $this->calculatePartialCostToolEdit($toolId);
        }
        $this->availableToolsEdit = Tool::whereIn('id', $this->selectedToolsEdit)->get();
    }

    public function updatedSelectedToolsEdit(): void
    {
        foreach ($this->availableToolsEdit as $tool) {
            $toolId = $tool->id;
            if (!in_array($toolId, $this->selectedToolsEdit)) {
                $this->quantitiesToolEdit[$toolId] = null;
                $this->requiredDaysToolEdit[$toolId] = null;
                $this->efficiencyInputsToolEdit[$toolId] = null;
                $this->efficienciesToolEdit[$toolId] = null;
                $this->partialCostsToolEdit[$toolId] = 0;
            }
        }
        $this->updateTotalToolCostEdit();
    }

    public function addToolEdit($toolId): void
    {
        if (!in_array($toolId, $this->selectedToolsEdit)) {
            $this->selectedToolsEdit[] = $toolId;
        } else {
            // Move the tool to the end of the array to ensure it is displayed last
            $this->selectedToolsEdit = array_merge(array_diff($this->selectedToolsEdit, [$toolId]), [$toolId]);
        }
        $this->toolSearchEdit = '';
        $this->updateTotalToolCostEdit();
    }

    public function removeToolEdit($toolId): void
    {
        $this->selectedToolsEdit = array_diff($this->selectedToolsEdit, [$toolId]);
        unset($this->quantitiesToolEdit[$toolId]);
        unset($this->requiredDaysToolEdit[$toolId]);
        unset($this->efficiencyInputsToolEdit[$toolId]);
        unset($this->efficienciesToolEdit[$toolId]);
        unset($this->partialCostsToolEdit[$toolId]);
        $this->updateTotalToolCostEdit();
    }

    public function calculatePartialCostToolEdit($toolId): void
    {
        $quantity = $this->quantitiesToolEdit[$toolId] ?? 0;
        $requiredDays = $this->requiredDaysToolEdit[$toolId] ?? 0;
        $efficiencyInput = $this->efficiencyInputsToolEdit[$toolId] ?? "1";
        $efficiency = DataTypeConverter::convertToFloat($efficiencyInput);

        if ($efficiency === null) {
            $this->partialCostsToolEdit[$toolId] = 0;
            $this->addError("efficiencyInputsToolEdit_$toolId", "Entrada de rendimiento inválida: '$efficiencyInput'");
        } else {
            $tool = Tool::find($toolId);
            $unitPrice = $tool->unit_price_per_day;
            $this->partialCostsToolEdit[$toolId] = $quantity * $requiredDays * $efficiency * $unitPrice;
        }

        $this->updateTotalToolCostEdit();
    }

    public function updatedQuantitiesToolEdit($value, $toolId): void
    {
        if (!is_numeric($value)) {
            $this->quantitiesToolEdit[$toolId] = null;
            return;
        }
        $this->calculatePartialCostToolEdit($toolId);
        $this->updateTotalToolCostEdit();
    }

    public function updatedRequiredDaysToolEdit($value, $toolId): void
    {
        if (!is_numeric($value)) {
            $this->requiredDaysToolEdit[$toolId] = null;
            return;
        }
        $this->calculatePartialCostToolEdit($toolId);
        $this->updateTotalToolCostEdit();
    }

    public function updatedEfficiencyInputsToolEdit($value, $toolId): void
    {
        $efficiency = DataTypeConverter::convertToFloat($value);

        if ($efficiency === null) {
            $this->addError("efficiencyInputsToolEdit_$toolId", "Entrada de rendimiento inválida: '$value'");
            return;
        }
        $this->efficienciesToolEdit[$toolId] = $efficiency;
        $this->efficiencyInputsToolEdit[$toolId] = $value;
        $this->calculatePartialCostToolEdit($toolId);
        $this->updateTotalToolCostEdit();
    }

    public function updateTotalToolCostEdit(): void
    {
        $this->totalToolCostEdit = array_sum($this->partialCostsToolEdit);
    }

    public function sendTotalToolCostEdit(): void
    {
        $this->dispatch('toolSelectionEditUpdated', [
            'selectedToolsEdit' => $this->selectedToolsEdit,
            'toolQuantitiesEdit' => $this->quantitiesToolEdit,
            'toolRequiredDaysEdit' => $this->requiredDaysToolEdit,
            'toolEfficienciesEdit' => $this->efficienciesToolEdit,
            'totalToolCostEdit' => $this->totalToolCostEdit,
        ]);

        if ($this->totalToolCostEdit > 0) {
            $this->dispatch('hideResourceFormEdit');
        }
    }

    public function render(): View
    {
        $filteredTools = Tool::query()
            ->where('name', 'like', "%$this->toolSearchEdit%")
            ->get();

        // Reverse the selected tools array to show the last selected at the top
        $selectedTools = Tool::whereIn('id', $this->selectedToolsEdit)->get()->sortByDesc(function ($tool) {
            return array_search($tool->id, $this->selectedToolsEdit);
        });

        return view('livewire.projects.tool-selection-edit', [
            'tools' => $filteredTools,
            'selectedTools' => $selectedTools,
        ]);
    }
}
