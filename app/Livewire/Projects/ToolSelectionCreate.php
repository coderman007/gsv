<?php

namespace App\Livewire\Projects;

use App\Helpers\DataTypeConverter;
use App\Models\Tool;
use Illuminate\View\View;
use Livewire\Component;

class ToolSelectionCreate extends Component
{
    public $search = '';
    public $availableTools = [];
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
        $this->availableTools = Tool::all();
        $this->updateTotalToolCostCreate();

        $this->selectedToolsCreate = session()->get('selectedToolsCreate', []);
        $this->quantitiesCreate = session()->get('quantitiesCreate', []);
        $this->requiredDaysCreate = session()->get('requiredDaysCreate', []);
        $this->efficiencyInputsCreate = session()->get('efficiencyInputsCreate', []);
        $this->efficienciesCreate = session()->get('efficienciesCreate', []);
        $this->partialCostsCreate = session()->get('partialCostsCreate', []);
        $this->totalToolCostCreate = session()->get('totalToolCostCreate', 0);
        $this->search = '';
    }

    public function dehydrate(): void
    {
        session()->put('selectedToolsCreate', $this->selectedToolsCreate);
        session()->put('quantitiesCreate', $this->quantitiesCreate);
        session()->put('requiredDaysCreate', $this->requiredDaysCreate);
        session()->put('efficiencyInputsCreate', $this->efficiencyInputsCreate);
        session()->put('efficienciesCreate', $this->efficienciesCreate);
        session()->put('partialCostsCreate', $this->partialCostsCreate);
        session()->put('totalToolCostCreate', $this->totalToolCostCreate);
    }

    public function addTool($toolId): void
    {
        if (!in_array($toolId, $this->selectedToolsCreate)) {
            $this->selectedToolsCreate[] = $toolId;
        } else {
            $this->selectedToolsCreate = array_merge(array_diff($this->selectedToolsCreate, [$toolId]), [$toolId]);
        }
        $this->search = '';
        $this->updateTotalToolCostCreate();
    }

    public function removeTool($toolId): void
    {
        $this->selectedToolsCreate = array_diff($this->selectedToolsCreate, [$toolId]);
        unset($this->quantitiesCreate[$toolId]);
        unset($this->requiredDaysCreate[$toolId]);
        unset($this->efficiencyInputsCreate[$toolId]);
        unset($this->efficienciesCreate[$toolId]);
        unset($this->partialCostsCreate[$toolId]);
        $this->updateTotalToolCostCreate();
    }

    public function calculatePartialCostCreate($toolId): void
    {
        $quantity = $this->quantitiesCreate[$toolId] ?? 0;
        $requiredDays = $this->requiredDaysCreate[$toolId] ?? 0;
        $efficiencyInput = $this->efficiencyInputsCreate[$toolId] ?? "1";
        $efficiency = DataTypeConverter::convertToFloat($efficiencyInput);

        if ($efficiency === null) {
            $this->partialCostsCreate[$toolId] = 0;
            $this->addError("efficiencyInputsCreate_$toolId", "El rendimiento ingresado es inválido.");
        } else {
            $tool = Tool::find($toolId);
            $dailyCost = $tool->unit_price_per_day;
            $this->partialCostsCreate[$toolId] = $quantity * $requiredDays * $efficiency * $dailyCost;
        }

        $this->updateTotalToolCostCreate();
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
        $this->dispatch('toolSelectionCreateUpdated', [
            'selectedToolsCreate' => $this->selectedToolsCreate,
            'toolQuantitiesCreate' => $this->quantitiesCreate,
            'toolRequiredDaysCreate' => $this->requiredDaysCreate,
            'toolEfficienciesCreate' => $this->efficienciesCreate,
            'totalToolCostCreate' => $this->totalToolCostCreate,
        ]);

        if ($this->totalToolCostCreate > 0) {
            $this->dispatch('hideResourceFormCreate');
        }
    }

    public function render(): View
    {
        $filteredTools = Tool::query()
            ->where('name', 'like', "%{$this->search}%")
            ->get();

        // Reverse the selected tools array to show the last selected at the top
        $selectedTools = Tool::whereIn('id', $this->selectedToolsCreate)->get()->sortByDesc(function ($tool) {
            return array_search($tool->id, $this->selectedToolsCreate);
        });

        return view('livewire.projects.tool-selection-create', [
            'tools' => $filteredTools,
            'selectedTools' => $selectedTools,
        ]);
    }
}
