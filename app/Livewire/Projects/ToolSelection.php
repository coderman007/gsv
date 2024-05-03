<?php

namespace App\Livewire\Projects;

use App\Helpers\DataTypeConverter;
use App\Models\Tool;
use Illuminate\View\View;
use Livewire\Component;

class ToolSelection extends Component
{
    public $search = '';
    public $tools = [];
    public $selectedTools = [];
    public $quantities = [];
    public $requiredDays = [];
    public $efficiencies = [];
    public $partialCosts = [];
    public $totalToolCost = 0;

    protected $rules = [
        'selectedTools' => 'required|array|min:1',
        'selectedTools.*' => 'exists:tools,id',
        'quantities.*' => 'nullable|numeric|min:0',
        'requiredDays.*' => 'nullable|numeric|min:0',
        'efficiencies.*' => 'nullable|string',
    ];

    public function mount(): void
    {
        $this->updateTotalToolCost();
    }
    public function updatedSearch(): void
    {
        $this->tools = Tool::where('name', 'like', '%' . $this->search . '%')
            ->get();
    }

    public function calculatePartialCost($toolId): void
    {
        if (in_array($toolId, $this->selectedTools)) {
            $quantity = $this->quantities[$toolId] ?? 0;
            $requiredDays = $this->requiredDays[$toolId] ?? 0;
            $efficiencyInput = $this->efficiencies[$toolId] ?? "1";

            $efficiency = DataTypeConverter::convertToFloat($efficiencyInput);

            if (is_numeric($quantity) && is_numeric($requiredDays) && $efficiency !== null) {
                $tool = Tool::find($toolId);
                $dailyCost = $tool->unit_price_per_day;
                $this->partialCosts[$toolId] = $quantity * $requiredDays * $efficiency * $dailyCost;
            } else {
                $this->partialCosts[$toolId] = 0; // Default to zero if invalid
            }
        } else {
            $this->partialCosts[$toolId] = 0;
        }
    }


    public function updatedQuantities($value, $toolId): void
    {
        // Si el valor no es numérico, establece el valor como null
        if (!is_numeric($value)) {
            $this->quantities[$toolId] = null;
        }

        // Recalcula el costo parcial y total para reflejar cualquier cambio
        $this->calculatePartialCost($toolId);
        $this->updateTotalToolCost();
    }

    public function updatedRequiredDays($value, $toolId): void
    {
        if (!is_numeric($value)) {
            $this->requiredDays[$toolId] = null;
        }

        // Recalcula el costo parcial y total para reflejar cualquier cambio
        $this->calculatePartialCost($toolId);
        $this->updateTotalToolCost();
    }

    public function updatedEfficiencies($value, $toolId): void
    {
        // Convierte el valor a float usando DataTypeConverter
        $efficiency = DataTypeConverter::convertToFloat($value);

        if ($efficiency === null) {
            // Emitir un mensaje de error si el valor es inválido
            $this->addError('efficiency', 'El valor de eficiencia es inválido.');
            return; // No sigas con el cálculo si el valor es inválido
        }

        // Actualizar el array de eficiencias con el nuevo valor
        $this->efficiencies[$toolId] = $efficiency;
        // Recalcular el costo parcial y total para reflejar cualquier cambio
        $this->calculatePartialCost($toolId);
        $this->updateTotalToolCost();
    }

    public function updateTotalToolCost(): void
    {
        $this->totalToolCost = array_sum($this->partialCosts);
    }

    public function sendTotalToolCost(): void
    {
        $this->dispatch('totalToolCostUpdated', $this->totalToolCost);

        $this->dispatch('toolSelectionUpdated', [
            'selectedTools' => $this->selectedTools,
            'toolQuantities' => $this->quantities,
            'toolRequiredDays' => $this->requiredDays,
            'toolEfficiencies' => $this->efficiencies,
            'totalToolCost' => $this->totalToolCost, // Enviar como número
        ]);

        if ($this->totalToolCost > 0) {
            $this->dispatch('hideResourceForm');
        }
    }


    public function render(): View
    {
        if (!empty($this->search)) {
            $this->tools = Tool::where('name', 'like', '%' . $this->search . '%')->get();
        }
        return view('livewire.projects.tool-selection');
    }
}
