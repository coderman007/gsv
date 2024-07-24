<?php

namespace App\Livewire\Projects;

use App\Helpers\DataTypeConverter;
use App\Models\Additional;
use Illuminate\View\View;
use Livewire\Component;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class AdditionalSelectionCreate extends Component
{
    public $availableAdditionalsCreate = [];
    public $selectedAdditionalsCreate = [];
    public $quantitiesAdditionalsCreate = [];
    public $efficiencyInputsAdditionalsCreate = [];
    public $efficienciesAdditionalsCreate = [];
    public $partialCostsAdditionalsCreate = [];
    public $totalAdditionalCostCreate = 0;
    public $additionalSearch = '';

    protected $rules = [
        'selectedAdditionalsCreate' => 'required|array|min:1',
        'selectedAdditionalsCreate.*' => 'exists:additionals,id',
        'quantitiesAdditionalsCreate.*' => 'nullable|numeric|min:0',
        'efficiencyInputsAdditionalsCreate.*' => 'nullable|string',
    ];

    /**
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
    public function mount(): void
    {
        $this->availableAdditionalsCreate = Additional::all();
        $this->updateTotalAdditionalCostCreate();

        $this->selectedAdditionalsCreate = session()->get('selectedAdditionalsCreate', []);
        $this->quantitiesAdditionalsCreate = session()->get('quantitiesAdditionalsCreate', []);
        $this->efficiencyInputsAdditionalsCreate = session()->get('efficiencyInputsAdditionalsCreate', []);
        $this->efficienciesAdditionalsCreate = session()->get('efficienciesAdditionalsCreate', []);
        $this->partialCostsAdditionalsCreate = session()->get('partialCostsAdditionalsCreate', []);
        $this->totalAdditionalCostCreate = session()->get('totalAdditionalCostCreate', 0);
        $this->additionalSearch = '';
    }

    public function dehydrate(): void
    {
        session()->put('selectedAdditionalsCreate', $this->selectedAdditionalsCreate);
        session()->put('quantitiesAdditionalsCreate', $this->quantitiesAdditionalsCreate);
        session()->put('efficiencyInputsAdditionalsCreate', $this->efficiencyInputsAdditionalsCreate);
        session()->put('efficienciesAdditionalsCreate', $this->efficienciesAdditionalsCreate);
        session()->put('partialCostsAdditionalsCreate', $this->partialCostsAdditionalsCreate);
        session()->put('totalAdditionalCostCreate', $this->totalAdditionalCostCreate);
    }

    public function addAdditionalCreate($additionalId): void
    {
        if (!in_array($additionalId, $this->selectedAdditionalsCreate)) {
            $this->selectedAdditionalsCreate[] = $additionalId;
        } else {
            // Move the additional to the end of the array to ensure it is displayed last
            $this->selectedAdditionalsCreate = array_merge(array_diff($this->selectedAdditionalsCreate, [$additionalId]), [$additionalId]);
        }
        $this->additionalSearch = '';
        $this->updateTotalAdditionalCostCreate();
    }

    public function removeAdditionalCreate($additionalId): void
    {
        $this->selectedAdditionalsCreate = array_diff($this->selectedAdditionalsCreate, [$additionalId]);
        unset($this->quantitiesAdditionalsCreate[$additionalId]);
        unset($this->efficiencyInputsAdditionalsCreate[$additionalId]);
        unset($this->efficienciesAdditionalsCreate[$additionalId]);
        unset($this->partialCostsAdditionalsCreate[$additionalId]);
        $this->updateTotalAdditionalCostCreate();
    }

    public function calculatePartialCostAdditionalCreate($additionalId): void
    {
        $quantity = $this->quantitiesAdditionalsCreate[$additionalId] ?? 0;
        $efficiencyInput = $this->efficiencyInputsAdditionalsCreate[$additionalId] ?? "1";
        $efficiency = DataTypeConverter::convertToFloat($efficiencyInput);

        if ($efficiency === null) {
            $this->partialCostsAdditionalsCreate[$additionalId] = 0;
            $this->addError("efficiencyInputsAdditionalsCreate_$additionalId", "Entrada de rendimiento inválida: '$efficiencyInput'");
        } else {
            $additional = Additional::find($additionalId);
            $unitPrice = $additional->unit_price;
            $this->partialCostsAdditionalsCreate[$additionalId] = $quantity * $efficiency * $unitPrice;
        }

        $this->updateTotalAdditionalCostCreate();
    }

    public function updatedQuantitiesAdditionalsCreate($value, $additionalId): void
    {
        if (!is_numeric($value)) {
            $this->quantitiesAdditionalsCreate[$additionalId] = null;
            return;
        }
        $this->calculatePartialCostAdditionalCreate($additionalId);
        $this->updateTotalAdditionalCostCreate();
    }

    public function updatedEfficiencyInputsAdditionalsCreate($value, $additionalId): void
    {
        $efficiency = DataTypeConverter::convertToFloat($value);

        if ($efficiency === null) {
            $this->addError("efficiencyInputsAdditionalsCreate_$additionalId", "Entrada de rendimiento inválida: '$value'");
            return;
        }
        $this->efficienciesAdditionalsCreate[$additionalId] = $efficiency;
        $this->efficiencyInputsAdditionalsCreate[$additionalId] = $value;
        $this->calculatePartialCostAdditionalCreate($additionalId);
        $this->updateTotalAdditionalCostCreate();
    }

    public function updateTotalAdditionalCostCreate(): void
    {
        $this->totalAdditionalCostCreate = array_sum($this->partialCostsAdditionalsCreate);
    }

    public function sendTotalAdditionalCostCreate(): void
    {
        $this->dispatch('additionalSelectionCreateUpdated', [
            'selectedAdditionalsCreate' => $this->selectedAdditionalsCreate,
            'additionalQuantitiesCreate' => $this->quantitiesAdditionalsCreate,
            'additionalEfficienciesCreate' => $this->efficienciesAdditionalsCreate,
            'totalAdditionalCostCreate' => $this->totalAdditionalCostCreate,
        ]);

        if ($this->totalAdditionalCostCreate > 0) {
            $this->dispatch('hideResourceFormCreate');
        }
    }

    public function render(): View
    {
        $filteredAdditionals = Additional::query()
            ->where('name', 'like', "%$this->additionalSearch%")
            ->get();

        // Reverse the selected additionals array to show the last selected at the top
        $selectedAdditionals = Additional::whereIn('id', $this->selectedAdditionalsCreate)->get()->sortByDesc(function ($additional) {
            return array_search($additional->id, $this->selectedAdditionalsCreate);
        });

        return view('livewire.projects.additional-selection-create', [
            'additionals' => $filteredAdditionals,
            'selectedAdditionals' => $selectedAdditionals,
        ]);
    }
}
