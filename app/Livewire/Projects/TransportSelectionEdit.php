<?php

namespace App\Livewire\Projects;

use App\Helpers\DataTypeConverter;
use App\Models\Transport;
use Illuminate\View\View;
use Livewire\Component;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class TransportSelectionEdit extends Component
{
    public $availableTransportsEdit = [];
    public $selectedTransportsEdit = [];
    public $quantitiesTransportEdit = [];
    public $requiredDaysTransportEdit = [];
    public $efficiencyInputsTransportEdit = [];
    public $efficienciesTransportEdit = [];
    public $partialCostsTransportEdit = [];
    public $totalTransportCostEdit = 0;
    public $transportSearchEdit = '';
    public $existingSelections = [];

    protected $rules = [
        'selectedTransportsEdit' => 'required|array|min:1',
        'selectedTransportsEdit.*' => 'exists:transports,id',
        'quantitiesTransportEdit.*' => 'nullable|numeric|min:0',
        'requiredDaysTransportEdit.*' => 'nullable|numeric|min:0',
        'efficiencyInputsTransportEdit.*' => 'nullable|string',
    ];

    /**
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
    public function mount(): void
    {
        $this->initializeFromExistingSelections();
        $this->updateTotalTransportCostEdit();

    }

    public function initializeFromExistingSelections(): void
    {
        foreach ($this->existingSelections as $selection) {
            $transportId = $selection['transport_id'];
            $this->selectedTransportsEdit[] = $transportId;
            $this->quantitiesTransportEdit[$transportId] = $selection['quantity'];
            $this->requiredDaysTransportEdit[$transportId] = $selection['required_days'];
            $this->efficiencyInputsTransportEdit[$transportId] = $selection['efficiency'];
            $this->efficienciesTransportEdit[$transportId] = DataTypeConverter::convertToFloat($selection['efficiency']);
            $this->calculatePartialCostTransportEdit($transportId);
        }

        $this->availableTransportsEdit = Transport::whereIn('id', $this->selectedTransportsEdit)->get();
    }

    public function updatedSelectedTransportsEdit(): void
    {
        foreach ($this->availableTransportsEdit as $transport) {
            $transportId = $transport->id;
            if (!in_array($transportId, $this->selectedTransportsEdit)) {
                $this->quantitiesTransportEdit[$transportId] = null;
                $this->requiredDaysTransportEdit[$transportId] = null;
                $this->efficiencyInputsTransportEdit[$transportId] = null;
                $this->efficienciesTransportEdit[$transportId] = null;
                $this->partialCostsTransportEdit[$transportId] = 0;
            }
        }
        $this->updateTotalTransportCostEdit();
    }

    public function addTransportEdit($transportId): void
    {
        if (!in_array($transportId, $this->selectedTransportsEdit)) {
            $this->selectedTransportsEdit[] = $transportId;
        } else {
            // Move the transport to the end of the array to ensure it is displayed last
            $this->selectedTransportsEdit = array_merge(array_diff($this->selectedTransportsEdit, [$transportId]), [$transportId]);
        }
        $this->transportSearchEdit = '';
        $this->updateTotalTransportCostEdit();
    }

    public function removeTransportEdit($transportId): void
    {
        $this->selectedTransportsEdit = array_diff($this->selectedTransportsEdit, [$transportId]);
        unset($this->quantitiesTransportEdit[$transportId]);
        unset($this->requiredDaysTransportEdit[$transportId]);
        unset($this->efficiencyInputsTransportEdit[$transportId]);
        unset($this->efficienciesTransportEdit[$transportId]);
        unset($this->partialCostsTransportEdit[$transportId]);
        $this->updateTotalTransportCostEdit();
    }

    public function calculatePartialCostTransportEdit($transportId): void
    {
        $quantity = $this->quantitiesTransportEdit[$transportId] ?? 0;
        $requiredDays = $this->requiredDaysTransportEdit[$transportId] ?? 0;
        $efficiencyInput = $this->efficiencyInputsTransportEdit[$transportId] ?? "1";
        $efficiency = DataTypeConverter::convertToFloat($efficiencyInput);

        if ($efficiency === null) {
            $this->partialCostsTransportEdit[$transportId] = 0;
            $this->addError("efficiencyInputsTransportEdit_$transportId", "Entrada de rendimiento inválida: '$efficiencyInput'");
        } else {
            $transport = Transport::find($transportId);
            $unitPrice = $transport->cost_per_day;
            $this->partialCostsTransportEdit[$transportId] = $quantity * $requiredDays * $efficiency * $unitPrice;
        }

        $this->updateTotalTransportCostEdit();
    }

    public function updatedQuantitiesTransportEdit($value, $transportId): void
    {
        if (!is_numeric($value)) {
            $this->quantitiesTransportEdit[$transportId] = null;
            return;
        }
        $this->calculatePartialCostTransportEdit($transportId);
        $this->updateTotalTransportCostEdit();
    }

    public function updatedRequiredDaysTransportEdit($value, $transportId): void
    {
        if (!is_numeric($value)) {
            $this->requiredDaysTransportEdit[$transportId] = null;
            return;
        }
        $this->calculatePartialCostTransportEdit($transportId);
        $this->updateTotalTransportCostEdit();
    }

    public function updatedEfficiencyInputsTransportEdit($value, $transportId): void
    {
        $efficiency = DataTypeConverter::convertToFloat($value);

        if ($efficiency === null) {
            $this->addError("efficiencyInputsTransportEdit_$transportId", "Entrada de rendimiento inválida: '$value'");
            return;
        }
        $this->efficienciesTransportEdit[$transportId] = $efficiency;
        $this->efficiencyInputsTransportEdit[$transportId] = $value;
        $this->calculatePartialCostTransportEdit($transportId);
        $this->updateTotalTransportCostEdit();
    }

    public function updateTotalTransportCostEdit(): void
    {
        $this->totalTransportCostEdit = array_sum($this->partialCostsTransportEdit);
    }

    public function sendTotalTransportCostEdit(): void
    {
        $this->dispatch('transportSelectionEditUpdated', [
            'selectedTransportsEdit' => $this->selectedTransportsEdit,
            'transportQuantitiesEdit' => $this->quantitiesTransportEdit,
            'transportRequiredDaysEdit' => $this->requiredDaysTransportEdit,
            'transportEfficienciesEdit' => $this->efficienciesTransportEdit,
            'totalTransportCostEdit' => $this->totalTransportCostEdit,
        ]);

        if ($this->totalTransportCostEdit > 0) {
            $this->dispatch('hideResourceFormEdit');
        }
    }

    public function render(): View
    {
        $filteredTransports = Transport::query()
            ->where('vehicle_type', 'like', "%$this->transportSearchEdit%")
            ->get();

        // Reverse the selected transports array to show the last selected at the top
        $selectedTransports = Transport::whereIn('id', $this->selectedTransportsEdit)->get()->sortByDesc(function ($transport) {
            return array_search($transport->id, $this->selectedTransportsEdit);
        });

        return view('livewire.projects.transport-selection-edit', [
            'transports' => $filteredTransports,
            'selectedTransports' => $selectedTransports,
        ]);
    }
}
