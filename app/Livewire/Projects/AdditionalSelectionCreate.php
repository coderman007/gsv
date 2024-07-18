<?php

namespace App\Livewire\Projects;

use App\Helpers\DataTypeConverter;
use App\Models\Additional;
use Illuminate\View\View;
use Livewire\Component;

class AdditionalSelectionCreate extends Component
{
    public $search = '';
    public $additionals = [];
    public $selectedAdditionalsCreate = [];
    public $quantitiesCreate = [];
    public $efficiencyInputsCreate = [];
    public $efficienciesCreate = [];
    public $partialCostsCreate = [];
    public $totalAdditionalCostCreate = 0;

    protected $rules = [
        'selectedAdditionalsCreate' => 'required|array|min:1',
        'selectedAdditionalsCreate.*' => 'exists:additionals,id',
        'quantitiesCreate.*' => 'nullable|numeric|min:0',
        'efficiencyInputsCreate.*' => 'nullable|string',
    ];

    public function mount(): void
    {
        $this->updateTotalAdditionalCostCreate();
    }

    public function updatedSearch(): void
    {
        $this->additionals = Additional::where('name', 'like', '%' . $this->search . '%')->get();
    }

    public function updatedSelectedAdditionalsCreate(): void
    {
        foreach ($this->additionals as $additional) {
            $additionalId = $additional->id;
            if (!in_array($additionalId, $this->selectedAdditionalsCreate)) {
                $this->quantitiesCreate[$additionalId] = null;
                $this->efficiencyInputsCreate[$additionalId] = null;
                $this->efficienciesCreate[$additionalId] = null;
                $this->partialCostsCreate[$additionalId] = 0;
            }
        }
        $this->updateTotalAdditionalCostCreate();
    }

    public function calculatePartialCostCreate($additionalId): void
    {
        if (in_array($additionalId, $this->selectedAdditionalsCreate)) {
            $quantity = $this->quantitiesCreate[$additionalId] ?? 0;
            $efficiencyInput = $this->efficiencyInputsCreate[$additionalId] ?? "1";
            $efficiency = DataTypeConverter::convertToFloat($efficiencyInput);

            if ($efficiency === null) {
                $this->partialCostsCreate[$additionalId] = 0;
                $this->addError("efficiencyInputsCreate_$additionalId", "Rendimiento inválido: '$efficiencyInput'.");
            } else {
                $additional = Additional::find($additionalId);
                $dailyCost = $additional->unit_price;
                $this->partialCostsCreate[$additionalId] = $quantity * $efficiency * $dailyCost;
            }
        } else {
            $this->partialCostsCreate[$additionalId] = 0;
        }
    }

    public function updatedQuantitiesCreate($value, $additionalId): void
    {
        if (!is_numeric($value)) {
            $this->quantitiesCreate[$additionalId] = null;
            return;
        }
        $this->calculatePartialCostCreate($additionalId);
        $this->updateTotalAdditionalCostCreate();
    }

    public function updatedEfficiencyInputsCreate($value, $additionalId): void
    {
        $efficiency = DataTypeConverter::convertToFloat($value);

        if ($efficiency === null) {
            $this->addError("efficiencyInputsCreate_$additionalId", "Valor de rendimiento inválido.");
            return;
        }

        $this->efficienciesCreate[$additionalId] = $efficiency;
        $this->efficiencyInputsCreate[$additionalId] = $value;
        $this->calculatePartialCostCreate($additionalId);
        $this->updateTotalAdditionalCostCreate();
    }

    public function updateTotalAdditionalCostCreate(): void
    {
        $this->totalAdditionalCostCreate = array_sum($this->partialCostsCreate);
    }

    public function sendTotalAdditionalCostCreate(): void
    {
        $this->dispatch("totalAdditionalCostCreateUpdated", $this->totalAdditionalCostCreate);

        $this->dispatch("additionalSelectionCreateUpdated", [
            "selectedAdditionalsCreate" => $this->selectedAdditionalsCreate,
            "additionalQuantitiesCreate" => $this->quantitiesCreate,
            "additionalEfficienciesCreate" => $this->efficienciesCreate,
            "totalAdditionalCostCreate" => $this->totalAdditionalCostCreate,
        ]);

        if ($this->totalAdditionalCostCreate > 0) {
            $this->dispatch("hideResourceFormCreate");
        }
    }

    public function render(): View
    {
        if (!empty($this->search)) {
            $this->additionals = Additional::where('name', 'like', '%' . $this->search . '%')->get();
        }
        return view("livewire.projects.additional-selection-create", [
            'additionals' => $this->additionals,
        ]);
    }
}
