<?php

namespace App\Livewire\Projects;

use App\Helpers\DataTypeConverter;
use App\Models\Additional;
use Illuminate\View\View;
use Livewire\Component;

class AdditionalSelectionEdit extends Component
{
    public $search = '';
    public $additionals = [];
    public $selectedAdditionalsEdit = [];
    public $quantitiesEdit = [];
    public $efficiencyInputsEdit = [];
    public $efficienciesEdit = [];
    public $partialCostsEdit = [];
    public $totalAdditionalCostEdit = 0;

    public $existingSelections = [];

    protected $rules = [
        'selectedAdditionalsEdit' => 'required|array|min:1',
        'selectedAdditionalsEdit.*' => 'exists:additionals,id',
        'quantitiesEdit.*' => 'nullable|numeric|min:0',
        'efficiencyInputsEdit.*' => 'nullable|string',
    ];

    public function mount(): void
    {
        $this->initializeFromExistingSelections();
        $this->updateTotalAdditionalCostEdit();
    }

    public function initializeFromExistingSelections(): void
    {
        foreach ($this->existingSelections as $selection) {
            $additionalId = $selection['additional_id'];
            $this->selectedAdditionalsEdit[] = $additionalId;
            $this->quantitiesEdit[$additionalId] = $selection['quantity'];
            $this->efficiencyInputsEdit[$additionalId] = $selection['efficiency'];
            $this->efficienciesEdit[$additionalId] = DataTypeConverter::convertToFloat($selection['efficiency']);
            $this->calculatePartialCostEdit($additionalId);
        }

        $this->additionals = Additional::whereIn('id', $this->selectedAdditionalsEdit)->get();
    }

    public function updatedSearch(): void
    {
        $this->additionals = Additional::where('name', 'like', '%' . $this->search . '%')->get();
    }

    public function updatedSelectedAdditionalsEdit(): void
    {
        foreach ($this->additionals as $additional) {
            $additionalId = $additional->id;
            if (!in_array($additionalId, $this->selectedAdditionalsEdit)) {
                $this->quantitiesEdit[$additionalId] = null;
                $this->efficiencyInputsEdit[$additionalId] = null;
                $this->efficienciesEdit[$additionalId] = null;
                $this->partialCostsEdit[$additionalId] = 0;
            }
        }
        $this->updateTotalAdditionalCostEdit();
    }

    public function calculatePartialCostEdit($additionalId): void
    {
        if (in_array($additionalId, $this->selectedAdditionalsEdit)) {
            $quantity = $this->quantitiesEdit[$additionalId] ?? 0;
            $efficiencyInput = $this->efficiencyInputsEdit[$additionalId] ?? "1";
            $efficiency = DataTypeConverter::convertToFloat($efficiencyInput);

            if ($efficiency === null) {
                $this->partialCostsEdit[$additionalId] = 0;
                $this->addError("efficiencyInputsEdit_$additionalId", "Rendimiento inválido: '$efficiencyInput'.");
            } else {
                $additional = Additional::find($additionalId);
                $dailyCost = $additional->unit_price;
                $this->partialCostsEdit[$additionalId] = $quantity * $efficiency * $dailyCost;
            }
        } else {
            $this->partialCostsEdit[$additionalId] = 0;
        }
    }

    public function updatedQuantitiesEdit($value, $additionalId): void
    {
        if (!is_numeric($value)) {
            $this->quantitiesEdit[$additionalId] = null;
            return;
        }
        $this->calculatePartialCostEdit($additionalId);
        $this->updateTotalAdditionalCostEdit();
    }

    public function updatedEfficiencyInputsEdit($value, $additionalId): void
    {
        $efficiency = DataTypeConverter::convertToFloat($value);

        if ($efficiency === null) {
            $this->addError("efficiencyInputsEdit_$additionalId", "Valor de rendimiento inválido.");
            return;
        }

        $this->efficienciesEdit[$additionalId] = $efficiency;
        $this->efficiencyInputsEdit[$additionalId] = $value;
        $this->calculatePartialCostEdit($additionalId);
        $this->updateTotalAdditionalCostEdit();
    }

    public function updateTotalAdditionalCostEdit(): void
    {
        $this->totalAdditionalCostEdit = array_sum($this->partialCostsEdit);
    }

    public function sendTotalAdditionalCostEdit(): void
    {
        $this->dispatch("totalAdditionalCostEditUpdated", $this->totalAdditionalCostEdit);

        $this->dispatch("additionalSelectionEditUpdated", [
            "selectedAdditionalsEdit" => $this->selectedAdditionalsEdit,
            "additionalQuantitiesEdit" => $this->quantitiesEdit,
            "additionalEfficienciesEdit" => $this->efficienciesEdit,
            "totalAdditionalCostEdit" => $this->totalAdditionalCostEdit,
        ]);

        if ($this->totalAdditionalCostEdit > 0) {
            $this->dispatch("hideResourceFormEdit");
        }
    }

    public function render(): View
    {
        if (!empty($this->search)) {
            $this->additionals = Additional::where('name', 'like', '%' . $this->search . '%')->get();
        }
        return view("livewire.projects.additional-selection-edit", [
            'additionals' => $this->additionals,
        ]);
    }
}

