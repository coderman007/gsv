<?php

namespace App\Livewire\Projects;

use App\Helpers\DataTypeConverter;
use App\Models\Additional;
use Illuminate\View\View;
use Livewire\Component;

class AdditionalSelection extends Component
{
    public $search = '';
    public $additionals = [];
    public $selectedAdditionals = [];
    public $quantities = [];
    public $efficiencyInputs = [];
    public $efficiencies = [];
    public $partialCosts = [];
    public $totalAdditionalCost = 0;

    public $isEdit = false;
    public $existingSelections = [];

    protected $rules = [
        'selectedAdditionals' => 'required|array|min:1',
        'selectedAdditionals.*' => 'exists:additionals,id',
        'quantities.*' => 'nullable|numeric|min:0',
        'efficiencyInputs.*' => 'nullable|string',
    ];

    public function mount(): void
    {
        $this->additionals = Additional::all();

        if ($this->isEdit) {
            $this->initializeFromExistingSelections();
        }

        $this->updateTotalAdditionalCost();
    }

    public function initializeFromExistingSelections(): void
    {
        foreach ($this->existingSelections as $selection) {
            $additionalId = $selection['additional_id'];
            $this->selectedAdditionals[] = $additionalId;
            $this->quantities[$additionalId] = $selection['quantity'];
            $this->efficiencyInputs[$additionalId] = $selection['efficiency'];
            $this->efficiencies[$additionalId] = DataTypeConverter::convertToFloat($selection['efficiency']);
            $this->calculatePartialCost($additionalId);
        }
    }

    public function updatedSelectedAdditionals(): void
    {
        foreach ($this->additionals as $additional) {
            $additionalId = $additional->id;
            if (!in_array($additionalId, $this->selectedAdditionals)) {
                $this->quantities[$additionalId] = null;
                $this->efficiencyInputs[$additionalId] = null;
                $this->efficiencies[$additionalId] = null;
                $this->partialCosts[$additionalId] = 0;
            }
        }
        $this->updateTotalAdditionalCost();
    }

    public function calculatePartialCost($additionalId): void
    {
        if (in_array($additionalId, $this->selectedAdditionals)) {
            $quantity = $this->quantities[$additionalId] ?? 0;
            $efficiencyInput = $this->efficiencyInputs[$additionalId] ?? "1";
            $efficiency = DataTypeConverter::convertToFloat($efficiencyInput);

            if ($efficiency === null) {
                $this->partialCosts[$additionalId] = 0;
                $this->addError("efficiency_$additionalId", "Rendimiento inválido: '$efficiencyInput'.");
            } else {
                $additional = Additional::find($additionalId);
                $dailyCost = $additional->unit_price;
                $this->partialCosts[$additionalId] = $quantity * $efficiency * $dailyCost;
            }
        } else {
            $this->partialCosts[$additionalId] = 0;
        }
    }

    public function updatedQuantities($value, $additionalId): void
    {
        if (!is_numeric($value)) {
            $this->quantities[$additionalId] = null;
            return;
        }
        $this->calculatePartialCost($additionalId);
        $this->updateTotalAdditionalCost();
    }

    public function updatedEfficiencyInputs($value, $additionalId): void
    {
        $efficiency = DataTypeConverter::convertToFloat($value);

        if ($efficiency === null) {
            $this->addError("efficiency_$additionalId", "Valor de rendimiento inválido.");
            return;
        }

        $this->efficiencies[$additionalId] = $efficiency;
        $this->efficiencyInputs[$additionalId] = $value;
        $this->calculatePartialCost($additionalId);
        $this->updateTotalAdditionalCost();
    }

    public function updateTotalAdditionalCost(): void
    {
        $this->totalAdditionalCost = array_sum($this->partialCosts);
    }

    public function sendTotalAdditionalCost(): void
    {
        $this->dispatch("totalAdditionalCostUpdated", $this->totalAdditionalCost);

        $this->dispatch("additionalSelectionUpdated", [
            "selectedAdditionals" => $this->selectedAdditionals,
            "additionalQuantities" => $this->quantities,
            "additionalEfficiencies" => $this->efficiencies,
            "totalAdditionalCost" => $this->totalAdditionalCost,
        ]);

        if ($this->totalAdditionalCost > 0) {
            $this->dispatch("hideResourceForm");
        }
    }

    public function render(): View
    {
        if (!empty($this->search)) {
            $this->additionals = Additional::where('name', 'like', '%' . $this->search . '%')->get();
        }
        return view("livewire.projects.additional-selection");
    }
}
