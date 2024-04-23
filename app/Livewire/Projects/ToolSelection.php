<?php

namespace App\Livewire\Projects;

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
    public $totalToolCost = 0;
    public $formattedTotalToolCost;

    protected $rules = [
        'selectedTools' => 'required|array|min:1',
        'selectedTools.*' => 'exists:tools,id',
        'quantities.*' => 'nullable|numeric|min:0',
        'requiredDays.*' => 'nullable|numeric|min:0', // Validación para días requeridos
    ];

    public function updatedSearch(): void
    {
        $this->tools = Tool::where('name', 'like', '%' . $this->search . '%')->get();
    }

    public function updatedQuantities($value, $toolId): void
    {
        // Si el valor no es numérico, establece el valor como null
        if (!is_numeric($value)) {
            $this->quantities[$toolId] = null;
        }

        // Recalcula el costo total para reflejar cualquier cambio
        $this->calculateTotalToolCost();
    }


    // Nuevo método para actualizar el costo total al cambiar los días requeridos
    public function updatedRequiredDays($value, $toolId): void
    {
        // Si el valor no es numérico, establece el valor como null
        if (!is_numeric($value)) {
            $this->requiredDays[$toolId] = null;
        }

        // Recalcula el costo total para reflejar cualquier cambio
        $this->calculateTotalToolCost();
    }


    public function calculateTotalToolCost(): void
    {
        $totalCost = 0;

        foreach ($this->selectedTools as $toolId) {
            // Usar valores predeterminados si la cantidad o los días requeridos son nulos
            $quantity = is_numeric($this->quantities[$toolId] ?? null) ? $this->quantities[$toolId] : 0;
            $days = is_numeric($this->requiredDays[$toolId] ?? null) ? $this->requiredDays[$toolId] : 0;

            $tool = Tool::find($toolId);
            if ($tool) {
                $totalCost += $quantity * $days * $tool->unit_price_per_day;
            }
        }

        $this->totalToolCost = $totalCost;
        $this->formattedTotalToolCost = number_format($totalCost, 2);
    }

    public function sendTotalToolCost(): void
    {
        $this->dispatch('totalToolCostUpdated', $this->totalToolCost);

        $this->dispatch('toolSelectionUpdated', [
            'selectedTools' => $this->selectedTools,
            'toolQuantities' => $this->quantities,
            'toolRequiredDays' => $this->requiredDays, // Añadir información de días requeridos
            'totalToolCost' => $this->totalToolCost,
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

