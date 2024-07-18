<?php

namespace App\Livewire\Projects;

use App\Helpers\DataTypeConverter;
use App\Models\Tool;
use Illuminate\View\View;
use Livewire\Component;

class ToolSelectionCreate extends Component
{
    public $search = '';
    public $tools = [];
    public $selectedToolsCreate = [];
    public $quantitiesCreate = [];
    public $requiredDaysCreate = [];
    public $efficiencyInputsCreate = [];
    public $efficienciesCreate = [];
    public $partialCostsCreate = [];
    public $totalToolCostCreate = 0;

    protected $rules = [
        'selectedToolsCreate' => 'required|array|min:1',
        'selectedToolsCreate.*' => 'exists:tools,id',
        'quantitiesCreate.*' => 'nullable|numeric|min:0',
        'requiredDaysCreate.*' => 'nullable|numeric|min:0',
        'efficiencyInputsCreate.*' => 'nullable|string',
    ];

    public function mount(): void
    {
        $this->updateTotalToolCostCreate();
    }

    public function updatedSearch(): void
    {
        $this->tools = Tool::where('name', 'like', '%' . $this->search . '%')->get();
    }

    public function updatedSelectedToolsCreate(): void
    {
        foreach ($this->tools as $tool) {
            $toolId = $tool->id;
            if (!in_array($toolId, $this->selectedToolsCreate)) {
                $this->quantitiesCreate[$toolId] = null;
                $this->requiredDaysCreate[$toolId] = null;
                $this->efficiencyInputsCreate[$toolId] = null;
                $this->efficienciesCreate[$toolId] = null;
                $this->partialCostsCreate[$toolId] = 0;
            }
        }
        $this->updateTotalToolCostCreate();
    }

    public function calculatePartialCostCreate($toolId): void
    {
        if (in_array($toolId, $this->selectedToolsCreate)) {
            $quantity = $this->quantitiesCreate[$toolId] ?? 0;
            $requiredDays = $this->requiredDaysCreate[$toolId] ?? 0;
            $efficiencyInput = $this->efficiencyInputsCreate[$toolId] ?? "1";
            $efficiency = DataTypeConverter::convertToFloat($efficiencyInput);

            if ($efficiency === null) {
                $this->partialCostsCreate[$toolId] = 0;
                $this->addError("efficiencyInputsCreate_$toolId", "El rendimiento ingresado es inválido.");
                return;
            }

            if (is_numeric($quantity) && is_numeric($requiredDays)) {
                $tool = Tool::find($toolId);
                $dailyCost = $tool->unit_price_per_day;
                $partialCost = $quantity * $requiredDays * $efficiency * $dailyCost;
                $this->partialCostsCreate[$toolId] = $partialCost;
            } else {
                $this->partialCostsCreate[$toolId] = 0;
            }
        } else {
            $this->partialCostsCreate[$toolId] = 0;
        }
    }

    public function updatedQuantitiesCreate($value, $toolId): void
    {
        if (!is_numeric($value)) {
            $this->quantitiesCreate[$toolId] = null;
            return;
        }

        $this->calculatePartialCostCreate($toolId);
        $this->updateTotalToolCostCreate();
    }

    public function updatedRequiredDaysCreate($value, $toolId): void
    {
        if (!is_numeric($value)) {
            $this->requiredDaysCreate[$toolId] = null;
            return;
        }

        $this->calculatePartialCostCreate($toolId);
        $this->updateTotalToolCostCreate();
    }

    public function updatedEfficiencyInputsCreate($value, $toolId): void
    {
        $efficiency = DataTypeConverter::convertToFloat($value);

        if ($efficiency === null) {
            $this->addError("efficiencyInputsCreate_$toolId", "El valor de rendimiento es inválido.");
            return;
        }

        $this->efficienciesCreate[$toolId] = $efficiency;
        $this->efficiencyInputsCreate[$toolId] = $value;
        $this->calculatePartialCostCreate($toolId);
        $this->updateTotalToolCostCreate();
    }

    public function updateTotalToolCostCreate(): void
    {
        $this->totalToolCostCreate = array_sum($this->partialCostsCreate);
    }

    public function sendTotalToolCostCreate(): void
    {
        $this->dispatch("totalToolCostCreateUpdated", $this->totalToolCostCreate);
        $this->dispatch("toolSelectionCreateUpdated", [
            "selectedToolsCreate" => $this->selectedToolsCreate,
            "toolQuantitiesCreate" => $this->quantitiesCreate,
            "toolRequiredDaysCreate" => $this->requiredDaysCreate,
            "toolEfficienciesCreate" => $this->efficienciesCreate,
            "totalToolCostCreate" => $this->totalToolCostCreate,
        ]);

        if ($this->totalToolCostCreate > 0) {
            $this->dispatch("hideResourceFormCreate");
        }
    }

    public function render(): View
    {
        if (!empty($this->search)) {
            $this->tools = Tool::where('name', 'like', '%' . $this->search . '%')->get();
        }
        return view("livewire.projects.tool-selection-create", [
            'tools' => $this->tools,
        ]);
    }
}
