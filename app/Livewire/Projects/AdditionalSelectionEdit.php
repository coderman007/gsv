<?php

namespace App\Livewire\Projects;

use App\Helpers\DataTypeConverter;
use App\Models\Additional;
use Illuminate\View\View;
use Livewire\Component;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class AdditionalSelectionEdit extends Component
{
    public $availableAdditionalsEdit = [];
    public $selectedAdditionalsEdit = [];
    public $quantitiesAdditionalsEdit = [];
    public $efficiencyInputsAdditionalsEdit = [];
    public $efficienciesAdditionalsEdit = [];
    public $partialCostsAdditionalsEdit = [];
    public $totalAdditionalCostEdit = 0;
    public $additionalSearchEdit = '';
    public $existingSelections = [];

    protected $rules = [
        'selectedAdditionalsEdit' => 'required|array|min:1',
        'selectedAdditionalsEdit.*' => 'exists:additionals,id',
        'quantitiesAdditionalsEdit.*' => 'nullable|numeric|min:0',
        'efficiencyInputsAdditionalsEdit.*' => 'nullable|string',
    ];

    /**
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
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
            $this->quantitiesAdditionalsEdit[$additionalId] = $selection['quantity'];
            $this->efficiencyInputsAdditionalsEdit[$additionalId] = $selection['efficiency'];
            $this->efficienciesAdditionalsEdit[$additionalId] = DataTypeConverter::convertToFloat($selection['efficiency']);
            $this->calculatePartialCostAdditionalEdit($additionalId);
        }

        $this->availableAdditionalsEdit = Additional::whereIn('id', $this->selectedAdditionalsEdit)->get();
    }

    public function updatedSelectedAdditionalsEdit(): void
    {
        foreach ($this->availableAdditionalsEdit as $additional) {
            $additionalId = $additional->id;
            if (!in_array($additionalId, $this->selectedAdditionalsEdit)) {
                $this->quantitiesAdditionalsEdit[$additionalId] = null;
                $this->efficiencyInputsAdditionalsEdit[$additionalId] = null;
                $this->efficienciesAdditionalsEdit[$additionalId] = null;
                $this->partialCostsAdditionalsEdit[$additionalId] = 0;
            }
        }
        $this->updateTotalAdditionalCostEdit();
    }

    public function addAdditionalEdit($additionalId): void
    {
        if (!in_array($additionalId, $this->selectedAdditionalsEdit)) {
            $this->selectedAdditionalsEdit[] = $additionalId;
        } else {
            // Move the additional to the end of the array to ensure it is displayed last
            $this->selectedAdditionalsEdit = array_merge(array_diff($this->selectedAdditionalsEdit, [$additionalId]), [$additionalId]);
        }
        $this->additionalSearchEdit = '';
        $this->updateTotalAdditionalCostEdit();
    }

    public function removeAdditionalEdit($additionalId): void
    {
        $this->selectedAdditionalsEdit = array_diff($this->selectedAdditionalsEdit, [$additionalId]);
        unset($this->quantitiesAdditionalsEdit[$additionalId]);
        unset($this->efficiencyInputsAdditionalsEdit[$additionalId]);
        unset($this->efficienciesAdditionalsEdit[$additionalId]);
        unset($this->partialCostsAdditionalsEdit[$additionalId]);
        $this->updateTotalAdditionalCostEdit();
    }

    public function calculatePartialCostAdditionalEdit($additionalId): void
    {
        $quantity = $this->quantitiesAdditionalsEdit[$additionalId] ?? 0;
        $efficiencyInput = $this->efficiencyInputsAdditionalsEdit[$additionalId] ?? "1";
        $efficiency = DataTypeConverter::convertToFloat($efficiencyInput);

        if ($efficiency === null) {
            $this->partialCostsAdditionalsEdit[$additionalId] = 0;
            $this->addError("efficiencyInputsAdditionalsEdit_$additionalId", "Entrada de rendimiento inválida: '$efficiencyInput'");
        } else {
            $additional = Additional::find($additionalId);
            $unitPrice = $additional->unit_price;
            $this->partialCostsAdditionalsEdit[$additionalId] = $quantity * $efficiency * $unitPrice;
        }

        $this->updateTotalAdditionalCostEdit();
    }

    public function updatedQuantitiesAdditionalsEdit($value, $additionalId): void
    {
        if (!is_numeric($value)) {
            $this->quantitiesAdditionalsEdit[$additionalId] = null;
            return;
        }
        $this->calculatePartialCostAdditionalEdit($additionalId);
        $this->updateTotalAdditionalCostEdit();
    }

    public function updatedEfficiencyInputsAdditionalsEdit($value, $additionalId): void
    {
        $efficiency = DataTypeConverter::convertToFloat($value);

        if ($efficiency === null) {
            $this->addError("efficiencyInputsAdditionalsEdit_$additionalId", "Entrada de rendimiento inválida: '$value'");
            return;
        }
        $this->efficienciesAdditionalsEdit[$additionalId] = $efficiency;
        $this->efficiencyInputsAdditionalsEdit[$additionalId] = $value;
        $this->calculatePartialCostAdditionalEdit($additionalId);
        $this->updateTotalAdditionalCostEdit();
    }

    public function updateTotalAdditionalCostEdit(): void
    {
        $this->totalAdditionalCostEdit = array_sum($this->partialCostsAdditionalsEdit);
    }

    public function sendTotalAdditionalCostEdit(): void
    {
        $this->dispatch('additionalSelectionEditUpdated', [
            'selectedAdditionalsEdit' => $this->selectedAdditionalsEdit,
            'additionalQuantitiesEdit' => $this->quantitiesAdditionalsEdit,
            'additionalEfficienciesEdit' => $this->efficienciesAdditionalsEdit,
            'totalAdditionalCostEdit' => $this->totalAdditionalCostEdit,
        ]);

        if ($this->totalAdditionalCostEdit > 0) {
            $this->dispatch('hideResourceFormEdit');
        }
    }

    public function render(): View
    {
        $filteredAdditionals = Additional::query()
            ->where('name', 'like', "%$this->additionalSearchEdit%")
            ->get();

        // Reverse the selected additionals array to show the last selected at the top
        $selectedAdditionals = Additional::whereIn('id', $this->selectedAdditionalsEdit)->get()->sortByDesc(function ($additional) {
            return array_search($additional->id, $this->selectedAdditionalsEdit);
        });

        return view('livewire.projects.additional-selection-create', [
            'additionals' => $filteredAdditionals,
            'selectedAdditionals' => $selectedAdditionals,
        ]);
    }
}
