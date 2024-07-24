<?php

namespace App\Livewire\Projects;

use App\Helpers\DataTypeConverter;
use App\Models\Transport;
use Illuminate\View\View;
use Livewire\Component;

class TransportSelectionCreate extends Component
{
    public $transportSearch = '';
    public $availableTransportsCreate = [];
    public $selectedTransportsCreate = [];
    public $quantitiesTransportCreate = [];
    public $requiredDaysTransportCreate = [];
    public $efficiencyInputsTransportCreate = [];
    public $efficienciesTransportCreate = [];
    public $partialCostsTransportCreate = [];
    public $totalTransportCostCreate = 0;

    protected $rules = [
        'selectedTransportsCreate' => 'required|array|min:1',
        'selectedTransportsCreate.*' => 'exists:transports,id',
        'quantitiesTransportCreate.*' => 'nullable|numeric|min:0',
        'requiredDaysTransportCreate.*' => 'nullable|numeric|min:0',
        'efficiencyInputsTransportCreate.*' => 'nullable|string',
    ];

    public function mount(): void
    {
        $this->availableTransportsCreate = Transport::all();
        $this->updateTotalTransportCostCreate();

        // Retrieve session data
        $this->selectedTransportsCreate = session()->get('selectedTransportsCreate', []);
        $this->quantitiesTransportCreate = session()->get('quantitiesTransportCreate', []);
        $this->requiredDaysTransportCreate = session()->get('requiredDaysTransportCreate', []);
        $this->efficiencyInputsTransportCreate = session()->get('efficiencyInputsTransportCreate', []);
        $this->efficienciesTransportCreate = session()->get('efficienciesTransportCreate', []);
        $this->partialCostsTransportCreate = session()->get('partialCostsTransportCreate', []);
        $this->totalTransportCostCreate = session()->get('totalTransportCostCreate', 0);
        $this->transportSearch = '';
    }

    public function dehydrate(): void
    {
        // Store session data
        session()->put('selectedTransportsCreate', $this->selectedTransportsCreate);
        session()->put('quantitiesTransportCreate', $this->quantitiesTransportCreate);
        session()->put('requiredDaysTransportCreate', $this->requiredDaysTransportCreate);
        session()->put('efficiencyInputsTransportCreate', $this->efficiencyInputsTransportCreate);
        session()->put('efficienciesTransportCreate', $this->efficienciesTransportCreate);
        session()->put('partialCostsTransportCreate', $this->partialCostsTransportCreate);
        session()->put('totalTransportCostCreate', $this->totalTransportCostCreate);
    }

    public function addTransport($transportId): void
    {
        if (!in_array($transportId, $this->selectedTransportsCreate)) {
            $this->selectedTransportsCreate[] = $transportId;
        } else {
            $this->selectedTransportsCreate = array_merge(array_diff($this->selectedTransportsCreate, [$transportId]), [$transportId]);
        }
        $this->transportSearch = '';
        $this->updateTotalTransportCostCreate();
    }

    public function removeTransport($transportId): void
    {
        $this->selectedTransportsCreate = array_diff($this->selectedTransportsCreate, [$transportId]);
        unset($this->quantitiesTransportCreate[$transportId]);
        unset($this->requiredDaysTransportCreate[$transportId]);
        unset($this->efficiencyInputsTransportCreate[$transportId]);
        unset($this->efficienciesTransportCreate[$transportId]);
        unset($this->partialCostsTransportCreate[$transportId]);
        $this->updateTotalTransportCostCreate();
    }

    public function calculatePartialCostTransportCreate($transportId): void
    {
        $quantity = $this->quantitiesTransportCreate[$transportId] ?? 0;
        $requiredDays = $this->requiredDaysTransportCreate[$transportId] ?? 0;
        $efficiencyInput = $this->efficiencyInputsTransportCreate[$transportId] ?? "1";
        $efficiency = DataTypeConverter::convertToFloat($efficiencyInput);

        if ($efficiency === null) {
            $this->partialCostsTransportCreate[$transportId] = 0;
            $this->addError("efficiencyInputsTransportCreate_$transportId", "Entrada de rendimiento inválida: '$efficiencyInput'");
        } else {
            $transport = Transport::find($transportId);
            $dailyCost = $transport->cost_per_day;
            $this->partialCostsTransportCreate[$transportId] = $quantity * $requiredDays * $efficiency * $dailyCost;
        }

        $this->updateTotalTransportCostCreate();
    }

    public function updatedQuantitiesTransportCreate($value, $transportId): void
    {
        if (!is_numeric($value)) {
            $this->quantitiesTransportCreate[$transportId] = null;
            return;
        }

        $this->calculatePartialCostTransportCreate($transportId);
        $this->updateTotalTransportCostCreate();
    }

    public function updatedRequiredDaysTransportCreate($value, $transportId): void
    {
        if (!is_numeric($value)) {
            $this->requiredDaysTransportCreate[$transportId] = null;
            return;
        }

        $this->calculatePartialCostTransportCreate($transportId);
        $this->updateTotalTransportCostCreate();
    }

    public function updatedEfficiencyInputsTransportCreate($value, $transportId): void
    {
        $efficiency = DataTypeConverter::convertToFloat($value);

        if ($efficiency === null) {
            $this->addError("efficiencyInputsTransportCreate_$transportId", "Entrada de rendimiento inválida: '$value'");
            return;
        }

        $this->efficienciesTransportCreate[$transportId] = $efficiency;
        $this->efficiencyInputsTransportCreate[$transportId] = $value;
        $this->calculatePartialCostTransportCreate($transportId);
        $this->updateTotalTransportCostCreate();
    }

    public function updateTotalTransportCostCreate(): void
    {
        $this->totalTransportCostCreate = array_sum($this->partialCostsTransportCreate);
    }

    public function sendTotalTransportCostCreate(): void
    {
        $this->dispatch('transportSelectionCreateUpdated', [
            'selectedTransportsCreate' => $this->selectedTransportsCreate,
            'transportQuantitiesCreate' => $this->quantitiesTransportCreate,
            'transportRequiredDaysCreate' => $this->requiredDaysTransportCreate,
            'transportEfficienciesCreate' => $this->efficienciesTransportCreate,
            'totalTransportCostCreate' => $this->totalTransportCostCreate,
        ]);

        if ($this->totalTransportCostCreate > 0) {
            $this->dispatch('hideResourceFormCreate');
        }
    }

    public function render(): View
    {
        $filteredTransports = Transport::query()
            ->where('vehicle_type', 'like', "%{$this->transportSearch}%")
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
