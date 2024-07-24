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
    public $quantitiesCreate = [];
    public $efficiencyInputsCreate = [];
    public $efficienciesCreate = [];
    public $partialCostsCreate = [];
    public $totalAdditionalCostCreate = 0;
    public $search = '';

    protected $rules = [
        'selectedAdditionalsCreate' => 'required|array|min:1',
        'selectedAdditionalsCreate.*' => 'exists:additionals,id',
        'quantitiesCreate.*' => 'nullable|numeric|min:0',
        'efficiencyInputsCreate.*' => 'nullable|string',
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
        $this->quantitiesCreate = session()->get('quantitiesCreate', []);
        $this->efficiencyInputsCreate = session()->get('efficiencyInputsCreate', []);
        $this->efficienciesCreate = session()->get('efficienciesCreate', []);
        $this->partialCostsCreate = session()->get('partialCostsCreate', []);
        $this->totalAdditionalCostCreate = session()->get('totalAdditionalCostCreate', 0);
        $this->search = '';
    }

    public function dehydrate(): void
    {
        session()->put('selectedAdditionalsCreate', $this->selectedAdditionalsCreate);
        session()->put('quantitiesCreate', $this->quantitiesCreate);
        session()->put('efficiencyInputsCreate', $this->efficiencyInputsCreate);
        session()->put('efficienciesCreate', $this->efficienciesCreate);
        session()->put('partialCostsCreate', $this->partialCostsCreate);
        session()->put('totalAdditionalCostCreate', $this->totalAdditionalCostCreate);
    }

    public function addAdditional($additionalId): void
    {
        if (!in_array($additionalId, $this->selectedAdditionalsCreate)) {
            $this->selectedAdditionalsCreate[] = $additionalId;
        } else {
            // Move the additional to the end of the array to ensure it is displayed last
            $this->selectedAdditionalsCreate = array_merge(array_diff($this->selectedAdditionalsCreate, [$additionalId]), [$additionalId]);
        }
        $this->search = '';
        $this->updateTotalAdditionalCostCreate();
    }

    public function removeAdditional($additionalId): void
    {
        $this->selectedAdditionalsCreate = array_diff($this->selectedAdditionalsCreate, [$additionalId]);
        unset($this->quantitiesCreate[$additionalId]);
        unset($this->efficiencyInputsCreate[$additionalId]);
        unset($this->efficienciesCreate[$additionalId]);
        unset($this->partialCostsCreate[$additionalId]);
        $this->updateTotalAdditionalCostCreate();
    }

    public function calculatePartialCostCreate($additionalId): void
    {
        $quantity = $this->quantitiesCreate[$additionalId] ?? 0;
        $efficiencyInput = $this->efficiencyInputsCreate[$additionalId] ?? "1";
        $efficiency = DataTypeConverter::convertToFloat($efficiencyInput);

        if ($efficiency === null) {
            $this->partialCostsCreate[$additionalId] = 0;
            $this->addError("efficiencyInputsCreate_$additionalId", "Entrada de rendimiento inválida: '$efficiencyInput'");
        } else {
            $additional = Additional::find($additionalId);
            $unitPrice = $additional->unit_price;
            $this->partialCostsCreate[$additionalId] = $quantity * $efficiency * $unitPrice;
        }

        $this->updateTotalAdditionalCostCreate();
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
            $this->addError("efficiencyInputsCreate_$additionalId", "Entrada de rendimiento inválida: '$value'");
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
        $this->dispatch('additionalSelectionCreateUpdated', [
            'selectedAdditionalsCreate' => $this->selectedAdditionalsCreate,
            'additionalQuantitiesCreate' => $this->quantitiesCreate,
            'additionalEfficienciesCreate' => $this->efficienciesCreate,
            'totalAdditionalCostCreate' => $this->totalAdditionalCostCreate,
        ]);

        if ($this->totalAdditionalCostCreate > 0) {
            $this->dispatch('hideResourceFormCreate');
        }
    }

    public function render(): View
    {
        $filteredAdditionals = Additional::query()
            ->where('name', 'like', "%$this->search%")
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
