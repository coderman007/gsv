<?php

namespace App\Livewire\Projects;

use App\Helpers\DataTypeConverter;
use App\Models\Tool;
use Illuminate\View\View;
use Livewire\Component;

class ToolSelectionCreate extends Component
{
    public $toolSearch = '';
    public $availableToolsCreate = [];
    public $selectedToolsCreate = [];
    public $quantitiesToolCreate = [];
    public $requiredDaysToolCreate = [];
    public $efficiencyInputsToolCreate = [];
    public $efficienciesToolCreate = [];
    public $partialCostsToolCreate = [];
    public $totalToolCostCreate = 0;

    protected $rules = [
        'selectedToolsCreate' => 'required|array|min:1',
        'selectedToolsCreate.*' => 'exists:tools,id',
        'quantitiesToolCreate.*' => 'nullable|numeric|min:0',
        'requiredDaysToolCreate.*' => 'nullable|numeric|min:0',
        'efficiencyInputsToolCreate.*' => 'nullable|string',
    ];

    public function mount(): void
    {
        $this->availableToolsCreate = Tool::all();
        $this->updateTotalToolCostCreate();

        $this->selectedToolsCreate = session()->get('selectedToolsCreate', []);
        $this->quantitiesToolCreate = session()->get('quantitiesToolCreate', []);
        $this->requiredDaysToolCreate = session()->get('requiredDaysToolCreate', []);
        $this->efficiencyInputsToolCreate = session()->get('efficiencyInputsToolCreate', []);
        $this->efficienciesToolCreate = session()->get('efficienciesToolCreate', []);
        $this->partialCostsToolCreate = session()->get('partialCostsToolCreate', []);
        $this->totalToolCostCreate = session()->get('totalToolCostCreate', 0);
        $this->toolSearch = '';
    }

    public function dehydrate(): void
    {
        session()->put('selectedToolsCreate', $this->selectedToolsCreate);
        session()->put('quantitiesToolCreate', $this->quantitiesToolCreate);
        session()->put('requiredDaysToolCreate', $this->requiredDaysToolCreate);
        session()->put('efficiencyInputsToolCreate', $this->efficiencyInputsToolCreate);
        session()->put('efficienciesToolCreate', $this->efficienciesToolCreate);
        session()->put('partialCostsToolCreate', $this->partialCostsToolCreate);
        session()->put('totalToolCostCreate', $this->totalToolCostCreate);
    }

    public function addTool($toolId): void
    {
        if (!in_array($toolId, $this->selectedToolsCreate)) {
            $this->selectedToolsCreate[] = $toolId;
        } else {
            $this->selectedToolsCreate = array_merge(array_diff($this->selectedToolsCreate, [$toolId]), [$toolId]);
        }
        $this->toolSearch = '';
        $this->updateTotalToolCostCreate();
    }

    public function removeTool($toolId): void
    {
        $this->selectedToolsCreate = array_diff($this->selectedToolsCreate, [$toolId]);
        unset($this->quantitiesToolCreate[$toolId]);
        unset($this->requiredDaysToolCreate[$toolId]);
        unset($this->efficiencyInputsToolCreate[$toolId]);
        unset($this->efficienciesToolCreate[$toolId]);
        unset($this->partialCostsToolCreate[$toolId]);
        $this->updateTotalToolCostCreate();
    }

    public function calculatePartialCostCreate($toolId): void
    {
        $quantity = $this->quantitiesToolCreate[$toolId] ?? 0;
        $requiredDays = $this->requiredDaysToolCreate[$toolId] ?? 0;
        $efficiencyInput = $this->efficiencyInputsToolCreate[$toolId] ?? "1";
        $efficiency = DataTypeConverter::convertToFloat($efficiencyInput);

        if ($efficiency === null) {
            $this->partialCostsToolCreate[$toolId] = 0;
            $this->addError("efficiencyInputsToolCreate_$toolId", "El rendimiento ingresado es inválido.");
        } else {
            $tool = Tool::find($toolId);
            $dailyCost = $tool->unit_price_per_day;
            $this->partialCostsToolCreate[$toolId] = $quantity * $requiredDays * $efficiency * $dailyCost;
        }

        $this->updateTotalToolCostCreate();
    }

    public function updatedQuantitiesToolCreate($value, $toolId): void
    {
        if (!is_numeric($value)) {
            $this->quantitiesToolCreate[$toolId] = null;
            return;
        }
        $this->calculatePartialCostCreate($toolId);
        $this->updateTotalToolCostCreate();
    }

    public function updatedRequiredDaysToolCreate($value, $toolId): void
    {
        if (!is_numeric($value)) {
            $this->requiredDaysToolCreate[$toolId] = null;
            return;
        }
        $this->calculatePartialCostCreate($toolId);
        $this->updateTotalToolCostCreate();
    }

    public function updatedEfficiencyInputsToolCreate($value, $toolId): void
    {
        $efficiency = DataTypeConverter::convertToFloat($value);

        if ($efficiency === null) {
            $this->addError("efficiencyInputsToolCreate_$toolId", "El valor de rendimiento es inválido.");
            return;
        }
        $this->efficienciesToolCreate[$toolId] = $efficiency;
        $this->efficiencyInputsToolCreate[$toolId] = $value;
        $this->calculatePartialCostCreate($toolId);
        $this->updateTotalToolCostCreate();
    }

    public function updateTotalToolCostCreate(): void
    {
        $this->totalToolCostCreate = array_sum($this->partialCostsToolCreate);
    }

    public function sendTotalToolCostCreate(): void
    {
        $this->dispatch('toolSelectionCreateUpdated', [
            'selectedToolsCreate' => $this->selectedToolsCreate,
            'toolQuantitiesCreate' => $this->quantitiesToolCreate,
            'toolRequiredDaysCreate' => $this->requiredDaysToolCreate,
            'toolEfficienciesCreate' => $this->efficienciesToolCreate,
            'totalToolCostCreate' => $this->totalToolCostCreate,
        ]);

        if ($this->totalToolCostCreate > 0) {
            $this->dispatch('hideResourceFormCreate');
        }
    }

    public function render(): View
    {
        $filteredTools = Tool::query()
            ->where('name', 'like', "%{$this->toolSearch}%")
            ->get();

        $selectedTools = Tool::whereIn('id', $this->selectedToolsCreate)->get()->sortByDesc(function ($tool) {
            return array_search($tool->id, $this->selectedToolsCreate);
        });

        return view('livewire.projects.tool-selection-create', [
            'tools' => $filteredTools,
            'selectedTools' => $selectedTools,
        ]);
    }
}
