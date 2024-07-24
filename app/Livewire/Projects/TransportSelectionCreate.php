<?php

namespace App\Livewire\Projects;

use App\Helpers\DataTypeConverter;
use App\Models\Transport;
use Illuminate\View\View;
use Livewire\Component;

class TransportSelectionCreate extends Component
{
    public $search = '';
    public $availableTransportsCreate = [];
    public $selectedTransportsCreate = [];
    public $quantitiesCreate = [];
    public $requiredDaysCreate = [];
    public $efficiencyInputsCreate = [];
    public $efficienciesCreate = [];
    public $partialCostsCreate = [];
    public $totalTransportCostCreate = 0;

    protected $rules = [
        'selectedTransportsCreate' => 'required|array|min:1',
        'selectedTransportsCreate.*' => 'exists:transports,id',
        'quantitiesCreate.*' => 'nullable|numeric|min:0',
        'requiredDaysCreate.*' => 'nullable|numeric|min:0',
        'efficiencyInputsCreate.*' => 'nullable|string',
    ];

    public function mount(): void
    {
        $this->availableTransportsCreate = Transport::all();
        $this->updateTotalTransportCostCreate();

        // Retrieve session data
        $this->selectedTransportsCreate = session()->get('selectedTransportsCreate', []);
        $this->quantitiesCreate = session()->get('quantitiesCreate', []);
        $this->requiredDaysCreate = session()->get('requiredDaysCreate', []);
        $this->efficiencyInputsCreate = session()->get('efficiencyInputsCreate', []);
        $this->efficienciesCreate = session()->get('efficienciesCreate', []);
        $this->partialCostsCreate = session()->get('partialCostsCreate', []);
        $this->totalTransportCostCreate = session()->get('totalTransportCostCreate', 0);
        $this->search = '';
    }

    public function dehydrate(): void
    {
        // Store session data
        session()->put('selectedTransportsCreate', $this->selectedTransportsCreate);
        session()->put('quantitiesCreate', $this->quantitiesCreate);
        session()->put('requiredDaysCreate', $this->requiredDaysCreate);
        session()->put('efficiencyInputsCreate', $this->efficiencyInputsCreate);
        session()->put('efficienciesCreate', $this->efficienciesCreate);
        session()->put('partialCostsCreate', $this->partialCostsCreate);
        session()->put('totalTransportCostCreate', $this->totalTransportCostCreate);
    }

    public function addTransport($transportId): void
    {
        if (!in_array($transportId, $this->selectedTransportsCreate)) {
            $this->selectedTransportsCreate[] = $transportId;
        } else {
            $this->selectedTransportsCreate = array_merge(array_diff($this->selectedTransportsCreate, [$transportId]), [$transportId]);
        }
        $this->search = '';
        $this->updateTotalTransportCostCreate();
    }

    public function removeTransport($transportId): void
    {
        $this->selectedTransportsCreate = array_diff($this->selectedTransportsCreate, [$transportId]);
        unset($this->quantitiesCreate[$transportId]);
        unset($this->requiredDaysCreate[$transportId]);
        unset($this->efficiencyInputsCreate[$transportId]);
        unset($this->efficienciesCreate[$transportId]);
        unset($this->partialCostsCreate[$transportId]);
        $this->updateTotalTransportCostCreate();
    }

    public function calculatePartialCostCreate($transportId): void
    {
        $quantity = $this->quantitiesCreate[$transportId] ?? 0;
        $requiredDays = $this->requiredDaysCreate[$transportId] ?? 0;
        $efficiencyInput = $this->efficiencyInputsCreate[$transportId] ?? "1";
        $efficiency = DataTypeConverter::convertToFloat($efficiencyInput);

        if ($efficiency === null) {
            $this->partialCostsCreate[$transportId] = 0;
            $this->addError("efficiencyInputsCreate_$transportId", "Entrada de rendimiento inválida: '$efficiencyInput'");
        } else {
            $transport = Transport::find($transportId);
            $dailyCost = $transport->cost_per_day;
            $this->partialCostsCreate[$transportId] = $quantity * $requiredDays * $efficiency * $dailyCost;
        }

        $this->updateTotalTransportCostCreate();
    }

    public function updatedQuantitiesCreate($value, $transportId): void
    {
        if (!is_numeric($value)) {
            $this->quantitiesCreate[$transportId] = null;
            return;
        }

        $this->calculatePartialCostCreate($transportId);
        $this->updateTotalTransportCostCreate();
    }

    public function updatedRequiredDaysCreate($value, $transportId): void
    {
        if (!is_numeric($value)) {
            $this->requiredDaysCreate[$transportId] = null;
            return;
        }

        $this->calculatePartialCostCreate($transportId);
        $this->updateTotalTransportCostCreate();
    }

    public function updatedEfficiencyInputsCreate($value, $transportId): void
    {
        $efficiency = DataTypeConverter::convertToFloat($value);

        if ($efficiency === null) {
            $this->addError("efficiencyInputsCreate_$transportId", "Entrada de rendimiento inválida: '$value'");
            return;
        }

        $this->efficienciesCreate[$transportId] = $efficiency;
        $this->efficiencyInputsCreate[$transportId] = $value;
        $this->calculatePartialCostCreate($transportId);
        $this->updateTotalTransportCostCreate();
    }

    public function updateTotalTransportCostCreate(): void
    {
        $this->totalTransportCostCreate = array_sum($this->partialCostsCreate);
    }

    public function sendTotalTransportCostCreate(): void
    {
        $this->dispatch('transportSelectionCreateUpdated', [
            'selectedTransportsCreate' => $this->selectedTransportsCreate,
            'transportQuantitiesCreate' => $this->quantitiesCreate,
            'transportRequiredDaysCreate' => $this->requiredDaysCreate,
            'transportEfficienciesCreate' => $this->efficienciesCreate,
            'totalTransportCostCreate' => $this->totalTransportCostCreate,
        ]);

        if ($this->totalTransportCostCreate > 0) {
            $this->dispatch('hideResourceFormCreate');
        }
    }

    public function render(): View
    {
        $filteredTransports = Transport::query()
            ->where('vehicle_type', 'like', "%{$this->search}%")
            ->get();

        // Reverse the selected transports array to show the last selected at the top
        $selectedTransports = Transport::whereIn('id', $this->selectedTransportsCreate)->get()->sortByDesc(function ($transport) {
            return array_search($transport->id, $this->selectedTransportsCreate);
        });

        return view('livewire.projects.transport-selection-create', [
            'transports' => $filteredTransports,
            'selectedTransports' => $selectedTransports,
        ]);
    }
}
