<?php

namespace App\Livewire\Projects;

use App\Helpers\DataTypeConverter;
use App\Models\Transport;
use Illuminate\View\View;
use Livewire\Component;

class TransportSelectionEdit extends Component
{
    public $availableTransportsEdit = [];
    public $selectedTransportsEdit = [];
    public $quantitiesEdit = [];
    public $requiredDaysEdit = [];
    public $efficiencyInputsEdit = [];
    public $efficienciesEdit = [];
    public $partialCostsEdit = [];
    public $totalTransportCostEdit = 0;
    public $existingSelections = [];

    protected $rules = [
        'selectedTransportsEdit' => 'required|array|min:1',
        'selectedTransportsEdit.*' => 'exists:transports,id',
        'quantitiesEdit.*' => 'nullable|numeric|min:0',
        'requiredDaysEdit.*' => 'nullable|numeric|min:0',
        'efficiencyInputsEdit.*' => 'nullable|string',
    ];

    public function mount(): void
    {
        $this->availableTransportsEdit = Transport::all();
        $this->initializeFromExistingSelections();
        $this->updateTotalTransportCostEdit();
    }

    public function initializeFromExistingSelections(): void
    {
        foreach ($this->existingSelections as $selection) {
            $transportId = $selection['transport_id'];
            $this->selectedTransportsEdit[] = $transportId;
            $this->quantitiesEdit[$transportId] = $selection['quantity'];
            $this->requiredDaysEdit[$transportId] = $selection['required_days'];
            $this->efficiencyInputsEdit[$transportId] = $selection['efficiency'];
            $this->efficienciesEdit[$transportId] = DataTypeConverter::convertToFloat($selection['efficiency']);
            $this->calculatePartialCostEdit($transportId);
        }
    }

    public function updatedSelectedTransportsEdit(): void
    {
        foreach ($this->availableTransportsEdit as $transport) {
            $transportId = $transport->id;
            if (!in_array($transportId, $this->selectedTransportsEdit)) {
                $this->quantitiesEdit[$transportId] = null;
                $this->requiredDaysEdit[$transportId] = null;
                $this->efficiencyInputsEdit[$transportId] = null;
                $this->efficienciesEdit[$transportId] = null;
                $this->partialCostsEdit[$transportId] = 0;
            }
        }
        $this->updateTotalTransportCostEdit();
    }


    public function calculatePartialCostEdit($transportId): void
    {
        if (in_array($transportId, $this->selectedTransportsEdit)) {
            $quantity = $this->quantitiesEdit[$transportId] ?? 0;
            $requiredDays = $this->requiredDaysEdit[$transportId] ?? 0;
            $efficiencyInput = $this->efficiencyInputsEdit[$transportId] ?? "1";
            $efficiency = DataTypeConverter::convertToFloat($efficiencyInput);

            if ($efficiency === null) {
                $this->partialCostsEdit[$transportId] = 0;
                $this->addError("efficiencyInputsEdit_$transportId", "Entrada de rendimiento inválida: '$efficiencyInput'");
                return;
            }

            if (is_numeric($quantity) && is_numeric($requiredDays)) {
                $transport = Transport::find($transportId);
                $dailyCost = $transport->cost_per_day;
                $partialCost = $quantity * $requiredDays * $efficiency * $dailyCost;
                $this->partialCostsEdit[$transportId] = $partialCost;
            } else {
                $this->partialCostsEdit[$transportId] = 0;
            }
        } else {
            $this->partialCostsEdit[$transportId] = 0;
        }
    }

    public function updatedQuantitiesEdit($value, $transportId): void
    {
        if (!is_numeric($value)) {
            $this->quantitiesEdit[$transportId] = null;
            return;
        }

        $this->calculatePartialCostEdit($transportId);
        $this->updateTotalTransportCostEdit();
    }

    public function updatedRequiredDaysEdit($value, $transportId): void
    {
        if (!is_numeric($value)) {
            $this->requiredDaysEdit[$transportId] = null;
            return;
        }

        $this->calculatePartialCostEdit($transportId);
        $this->updateTotalTransportCostEdit();
    }

    public function updatedEfficiencyInputsEdit($value, $transportId): void
    {
        $efficiency = DataTypeConverter::convertToFloat($value);

        if ($efficiency === null) {
            $this->addError("efficiencyInputsEdit_$transportId", "Entrada de rendimiento inválida: '$value'");
            return;
        }

        $this->efficienciesEdit[$transportId] = $efficiency;
        $this->efficiencyInputsEdit[$transportId] = $value;
        $this->calculatePartialCostEdit($transportId);
        $this->updateTotalTransportCostEdit();
    }

    public function updateTotalTransportCostEdit(): void
    {
        $this->totalTransportCostEdit = array_sum($this->partialCostsEdit);
    }

    public function sendTotalTransportCostEdit(): void
    {
//        $this->dispatch("totalTransportCostEditUpdated", $this->totalTransportCostEdit);
        $this->dispatch("transportSelectionEditUpdated", [
            "selectedTransportsEdit" => $this->selectedTransportsEdit,
            "transportQuantitiesEdit" => $this->quantitiesEdit,
            "transportRequiredDaysEdit" => $this->requiredDaysEdit,
            "transportEfficienciesEdit" => $this->efficienciesEdit,
            "totalTransportCostEdit" => $this->totalTransportCostEdit,
        ]);

        if ($this->totalTransportCostEdit > 0) {
            $this->dispatch("hideResourceFormEdit");
        }
    }

    public function render(): View
    {
        return view("livewire.projects.transport-selection-edit", [
            'transports' => $this->availableTransportsEdit,
        ]);
    }
}

