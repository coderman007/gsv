<?php

namespace App\Livewire\Projects;

use App\Helpers\DataTypeConverter; // Asumo que esto contiene la lógica para convertir cadenas a números
use App\Models\Position;
use Illuminate\View\View;
use Livewire\Component;

class PositionSelection extends Component
{
    public $positions = [];
    public $selectedPositions = [];
    public $quantities = [];
    public $requiredDays = [];
    public $efficiencyInputs = []; // Ahora vamos a usar esta variable para el input de rendimiento
    public $efficiencies = []; // Esto almacenará las eficiencias como valores numéricos
    public $partialCosts = [];
    public $totalLaborCost = 0;

    protected $rules = [
        'selectedPositions' => 'required|array|min:1',
        'selectedPositions.*' => 'exists:positions,id',
        'quantities.*' => 'nullable|numeric|min:0',
        'requiredDays.*' => 'nullable|numeric|min:0',
        'efficiencyInputs.*' => 'nullable|string', // Aceptamos cualquier cadena para los inputs
    ];

    public function mount(): void
    {
        $this->positions = Position::all();
        $this->updateTotalLaborCost();
    }

    public function calculatePartialCost($positionId): void
    {
        if (in_array($positionId, $this->selectedPositions)) {
            $quantity = $this->quantities[$positionId] ?? 0;
            $requiredDays = $this->requiredDays[$positionId] ?? 0;
            $efficiencyInput = $this->efficiencyInputs[$positionId] ?? "1"; // Cadena por defecto

            $efficiency = DataTypeConverter::convertToFloat($efficiencyInput); // Conversión a número

            if ($efficiency === null) {
                // Si la conversión falla, establecemos el costo parcial en 0
                $this->partialCosts[$positionId] = 0;
                $this->addError('efficiencyInput', "Entrada de rendimiento inválida: '$efficiencyInput'");
            } else {
                $position = Position::find($positionId);
                $dailyCost = $position->real_daily_cost;

                $this->partialCosts[$positionId] = $quantity * $requiredDays * $efficiency * $dailyCost;
            }
        } else {
            $this->partialCosts[$positionId] = 0;
        }

        $this->dispatch('efficiencyInputUpdated', $this->efficiencyInputs); // Emitir evento para la vista
    }

    public function updatedQuantities($value, $positionId): void
    {
        if (!is_numeric($value)) {
            $this->quantities[$positionId] = null; // Restablecemos a null si el valor no es numérico
            return;
        }

        $this->calculatePartialCost($positionId); // Recalcula el costo parcial
        $this->updateTotalLaborCost(); // Actualiza el costo total de mano de obra
    }

    public function updatedRequiredDays($value, $positionId): void
    {
        if (!is_numeric($value)) {
            $this->requiredDays[$positionId] = null; // Restablecemos a null si el valor no es numérico
            return;
        }

        $this->calculatePartialCost($positionId); // Recalcula el costo parcial
        $this->updateTotalLaborCost(); // Actualiza el costo total de mano de obra
    }

    public function updatedEfficiencyInputs($value, $positionId): void
    {
        $efficiency = DataTypeConverter::convertToFloat($value); // Intenta convertir la cadena a un número

        if ($efficiency === null) {
            // Emite un error si la conversión falla
            $this->addError('efficiencyInput', "Entrada de rendimiento inválida: '$value'");
            return;
        }

        $this->efficiencies[$positionId] = $efficiency; // Actualiza la eficiencia como valor numérico
        $this->efficiencyInputs[$positionId] = $value; // Almacena la cadena de entrada
        $this->calculatePartialCost($positionId); // Recalcula el costo parcial
        $this->updateTotalLaborCost(); // Actualiza el costo total
    }

    public function updateTotalLaborCost(): void
    {
        $this->totalLaborCost = array_sum($this->partialCosts); // Suma de todos los costos parciales
    }

    public function sendTotalLaborCost(): void
    {
        $this->dispatch('totalLaborCostUpdated', $this->totalLaborCost); // Emite evento con el costo total

        $this->dispatch('positionSelectionUpdated', [
            'selectedPositions' => $this->selectedPositions,
            'quantities' => $this->quantities,
            'requiredDays' => $this->requiredDays,
            'efficiencies' => $this->efficiencies,
            'totalLaborCost' => $this->totalLaborCost,
        ]);

        if ($this->totalLaborCost > 0) {
            $this->dispatch('hideResourceForm'); // Ejemplo de otro evento
        }
    }

    public function render(): View
    {
        return view('livewire.projects.position-selection', [
            'positions' => $this->positions,
        ]);
    }
}
