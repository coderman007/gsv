<?php

namespace App\Livewire\Projects;

use App\Helpers\DataTypeConverter;
use App\Models\Transport;
use Illuminate\View\View;
use Livewire\Component;

class TransportSelectionCreate extends Component
{
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
    }

    public function updatedSelectedTransportsCreate(): void
    {
        foreach ($this->availableTransportsCreate as $transport) {
            $transportId = $transport->id;
            if (!in_array($transportId, $this->selectedTransportsCreate)) {
                $this->quantitiesCreate[$transportId] = null;
                $this->requiredDaysCreate[$transportId] = null;
                $this->efficiencyInputsCreate[$transportId] = null;
                $this->efficienciesCreate[$transportId] = null;
                $this->partialCostsCreate[$transportId] = 0;
            }
        }
        $this->updateTotalTransportCostCreate();
    }


    public function calculatePartialCostCreate($transportId): void
    {
        if (in_array($transportId, $this->selectedTransportsCreate)) {
            $quantity = $this->quantitiesCreate[$transportId] ?? 0;
            $requiredDays = $this->requiredDaysCreate[$transportId] ?? 0;
            $efficiencyInput = $this->efficiencyInputsCreate[$transportId] ?? "1";
            $efficiency = DataTypeConverter::convertToFloat($efficiencyInput);

            if ($efficiency === null) {
                $this->partialCostsCreate[$transportId] = 0;
                $this->addError("efficiencyInputsCreate_$transportId", "Entrada de rendimiento inválida: '$efficiencyInput'");
                return;
            }

            if (is_numeric($quantity) && is_numeric($requiredDays)) {
                $transport = Transport::find($transportId);
                $dailyCost = $transport->cost_per_day;
                $partialCost = $quantity * $requiredDays * $efficiency * $dailyCost;
                $this->partialCostsCreate[$transportId] = $partialCost;
            } else {
                $this->partialCostsCreate[$transportId] = 0;
            }
        } else {
            $this->partialCostsCreate[$transportId] = 0;
        }
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
//        $this->dispatch("totalTransportCostCreateUpdated", $this->totalTransportCostCreate);
        $this->dispatch("transportSelectionCreateUpdated", [
            "selectedTransportsCreate" => $this->selectedTransportsCreate,
            "transportQuantitiesCreate" => $this->quantitiesCreate,
            "transportRequiredDaysCreate" => $this->requiredDaysCreate,
            "transportEfficienciesCreate" => $this->efficienciesCreate,
            "totalTransportCostCreate" => $this->totalTransportCostCreate,
        ]);

        if ($this->totalTransportCostCreate > 0) {
            $this->dispatch("hideResourceFormCreate");
        }
    }

    public function render(): View
    {
        return view("livewire.projects.transport-selection-create", [
            'transports' => $this->availableTransportsCreate,
        ]);
    }
}

