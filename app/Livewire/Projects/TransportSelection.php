<?php

namespace App\Livewire\Projects;

use App\Helpers\DataTypeConverter;
use App\Models\Transport;
use Illuminate\View\View;
use Livewire\Component;

class TransportSelection extends Component
{
    public $transports = [];
    public $selectedTransports = [];
    public $quantities = [];
    public $requiredDays = [];
    public $efficiencyInputs = [];
    public $efficiencies = [];
    public $partialCosts = [];
    public $totalTransportCost = 0;

    public $isEdit = false;
    public $existingSelections = [];

    protected $rules = [
        'selectedTransports' => 'required|array|min:1',
        'selectedTransports.*' => 'exists:transports,id',
        'quantities.*' => 'nullable|numeric|min:0',
        'requiredDays.*' => 'nullable|numeric|min:0',
        'efficiencyInputs.*' => 'nullable|string',
    ];

    public function mount(): void
    {
        $this->transports = Transport::all();

        if ($this->isEdit) {
            $this->initializeFromExistingSelections();
        }

        $this->updateTotalTransportCost();
    }

    public function initializeFromExistingSelections(): void
    {
        foreach ($this->existingSelections as $selection) {
            $transportId = $selection['transport_id'];
            $this->selectedTransports[] = $transportId;
            $this->quantities[$transportId] = $selection['quantity'];
            $this->requiredDays[$transportId] = $selection['required_days'];
            $this->efficiencyInputs[$transportId] = $selection['efficiency'];
            $this->efficiencies[$transportId] = DataTypeConverter::convertToFloat($selection['efficiency']);
            $this->calculatePartialCost($transportId);
        }
    }

    public function updatedSelectedTransports(): void
    {
        foreach ($this->transports as $transport) {
            $transportId = $transport->id;
            if (!in_array($transportId, $this->selectedTransports)) {
                $this->quantities[$transportId] = null;
                $this->requiredDays[$transportId] = null;
                $this->efficiencyInputs[$transportId] = null;
                $this->efficiencies[$transportId] = null;
                $this->partialCosts[$transportId] = 0;
            }
        }
        $this->updateTotalTransportCost();
    }

    public function calculatePartialCost($transportId): void
    {
        if (in_array($transportId, $this->selectedTransports)) {
            $quantity = $this->quantities[$transportId] ?? 0;
            $requiredDays = $this->requiredDays[$transportId] ?? 0;
            $efficiencyInput = $this->efficiencyInputs[$transportId] ?? "1";

            $efficiency = DataTypeConverter::convertToFloat($efficiencyInput);

            if ($efficiency === null) {
                $this->partialCosts[$transportId] = 0;
                $this->addError("efficiency_$transportId", "Rendimiento inválido: '$efficiencyInput'.");
                return;
            }

            if (is_numeric($quantity) && is_numeric($requiredDays)) {
                $transport = Transport::find($transportId);
                $dailyCost = $transport->cost_per_day;

                $partialCost = $quantity * $requiredDays * $efficiency * $dailyCost;
                $this->partialCosts[$transportId] = $partialCost;
            } else {
                $this->partialCosts[$transportId] = 0;
            }
        } else {
            $this->partialCosts[$transportId] = 0;
        }
    }

    public function updatedQuantities($value, $transportId): void
    {
        if (!is_numeric($value)) {
            $this->quantities[$transportId] = null;
            return;
        }

        $this->calculatePartialCost($transportId);
        $this->updateTotalTransportCost();
    }

    public function updatedRequiredDays($value, $transportId): void
    {
        if (!is_numeric($value)) {
            $this->requiredDays[$transportId] = null;
            return;
        }

        $this->calculatePartialCost($transportId);
        $this->updateTotalTransportCost();
    }

    public function updatedEfficiencyInputs($value, $transportId): void
    {
        $efficiency = DataTypeConverter::convertToFloat($value);

        if ($efficiency === null) {
            $this->addError("efficiency_$transportId", "Valor de rendimiento inválido.");
            return;
        }

        $this->efficiencies[$transportId] = $efficiency;
        $this->efficiencyInputs[$transportId] = $value;

        $this->calculatePartialCost($transportId);
        $this->updateTotalTransportCost();
    }

    public function updateTotalTransportCost(): void
    {
        $this->totalTransportCost = array_sum($this->partialCosts);
    }

    public function sendTotalTransportCost(): void
    {
        $this->dispatch("totalTransportCostUpdated", $this->totalTransportCost);

        $this->dispatch("transportSelectionUpdated", [
            "selectedTransports" => $this->selectedTransports,
            "transportQuantities" => $this->quantities,
            "transportRequiredDays" => $this->requiredDays,
            "transportEfficiencies" => $this->efficiencies,
            "totalTransportCost" => $this->totalTransportCost,
        ]);

        if ($this->totalTransportCost > 0) {
            $this->dispatch("hideResourceForm");
        }
    }

    public function render(): View
    {
        return view("livewire.projects.transport-selection");
    }
}
