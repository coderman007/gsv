<?php

namespace App\Livewire\Projects;

use App\Helpers\DataTypeConverter;
use App\Models\Position;
use Illuminate\View\View;
use Livewire\Component;

class PositionSelectionCreate extends Component
{
    public $availablePositionsCreate = [];
    public $selectedPositionsCreate = [];
    public $quantitiesCreate = [];
    public $requiredDaysCreate = [];
    public $efficiencyInputsCreate = [];
    public $efficienciesCreate = [];
    public $partialCostsCreate = [];
    public $totalLaborCostCreate = 0;
    public $search = ''; // Nueva propiedad para manejar el valor de búsqueda

    protected $rules = [
        'selectedPositionsCreate' => 'required|array|min:1',
        'selectedPositionsCreate.*' => 'exists:positions,id',
        'quantitiesCreate.*' => 'nullable|numeric|min:0',
        'requiredDaysCreate.*' => 'nullable|numeric|min:0',
        'efficiencyInputsCreate.*' => 'nullable|string',
    ];

    public function mount(): void
    {
        $this->availablePositionsCreate = Position::all();
        $this->updateTotalLaborCostCreate();

        $this->selectedPositionsCreate = session()->get('selectedPositionsCreate', []);
        $this->quantitiesCreate = session()->get('quantitiesCreate', []);
        $this->requiredDaysCreate = session()->get('requiredDaysCreate', []);
        $this->efficiencyInputsCreate = session()->get('efficiencyInputsCreate', []);
        $this->efficienciesCreate = session()->get('efficienciesCreate', []);
        $this->partialCostsCreate = session()->get('partialCostsCreate', []);
        $this->totalLaborCostCreate = session()->get('totalLaborCostCreate', 0);
        $this->search = ''; // Inicializa el valor de búsqueda
    }

    public function dehydrate(): void
    {
        session()->put('selectedPositionsCreate', $this->selectedPositionsCreate);
        session()->put('quantitiesCreate', $this->quantitiesCreate);
        session()->put('requiredDaysCreate', $this->requiredDaysCreate);
        session()->put('efficiencyInputsCreate', $this->efficiencyInputsCreate);
        session()->put('efficienciesCreate', $this->efficienciesCreate);
        session()->put('partialCostsCreate', $this->partialCostsCreate);
        session()->put('totalLaborCostCreate', $this->totalLaborCostCreate);
    }

    public function addPosition($positionId): void
    {
        if (!in_array($positionId, $this->selectedPositionsCreate)) {
            $this->selectedPositionsCreate[] = $positionId;
        }
        $this->search = ''; // Limpia el campo de búsqueda
        $this->updateTotalLaborCostCreate();
    }

    public function removePosition($positionId): void
    {
        $this->selectedPositionsCreate = array_diff($this->selectedPositionsCreate, [$positionId]);
        unset($this->quantitiesCreate[$positionId]);
        unset($this->requiredDaysCreate[$positionId]);
        unset($this->efficiencyInputsCreate[$positionId]);
        unset($this->efficienciesCreate[$positionId]);
        unset($this->partialCostsCreate[$positionId]);
        $this->updateTotalLaborCostCreate();
    }

    public function calculatePartialCostCreate($positionId): void
    {
        $quantity = $this->quantitiesCreate[$positionId] ?? 0;
        $requiredDays = $this->requiredDaysCreate[$positionId] ?? 0;
        $efficiencyInput = $this->efficiencyInputsCreate[$positionId] ?? "1";
        $efficiency = DataTypeConverter::convertToFloat($efficiencyInput);

        if ($efficiency === null) {
            $this->partialCostsCreate[$positionId] = 0;
            $this->addError("efficiencyInputsCreate_$positionId", "Entrada de rendimiento inválida: '$efficiencyInput'");
        } else {
            $position = Position::find($positionId);
            $dailyCost = $position->real_daily_cost;
            $this->partialCostsCreate[$positionId] = $quantity * $requiredDays * $efficiency * $dailyCost;
        }

        $this->updateTotalLaborCostCreate();
    }

    public function updatedQuantitiesCreate($value, $positionId): void
    {
        if (!is_numeric($value)) {
            $this->quantitiesCreate[$positionId] = null;
            return;
        }
        $this->calculatePartialCostCreate($positionId);
        $this->updateTotalLaborCostCreate();
    }

    public function updatedRequiredDaysCreate($value, $positionId): void
    {
        if (!is_numeric($value)) {
            $this->requiredDaysCreate[$positionId] = null;
            return;
        }
        $this->calculatePartialCostCreate($positionId);
        $this->updateTotalLaborCostCreate();
    }

    public function updatedEfficiencyInputsCreate($value, $positionId): void
    {
        $efficiency = DataTypeConverter::convertToFloat($value);

        if ($efficiency === null) {
            $this->addError("efficiencyInputsCreate_$positionId", "Entrada de rendimiento inválida: '$value'");
            return;
        }
        $this->efficienciesCreate[$positionId] = $efficiency;
        $this->efficiencyInputsCreate[$positionId] = $value;
        $this->calculatePartialCostCreate($positionId);
        $this->updateTotalLaborCostCreate();
    }

    public function updateTotalLaborCostCreate(): void
    {
        $this->totalLaborCostCreate = array_sum($this->partialCostsCreate);
    }

    public function sendTotalLaborCostCreate(): void
    {
        $this->dispatch('positionSelectionCreateUpdated', [
            'selectedPositionsCreate' => $this->selectedPositionsCreate,
            'positionQuantitiesCreate' => $this->quantitiesCreate,
            'positionRequiredDaysCreate' => $this->requiredDaysCreate,
            'positionEfficienciesCreate' => $this->efficienciesCreate,
            'totalLaborCostCreate' => $this->totalLaborCostCreate,
        ]);

        if ($this->totalLaborCostCreate > 0) {
            $this->dispatch('hideResourceFormCreate');
        }
    }

    public function render(): View
    {
        $filteredPositions = Position::query()
            ->where('name', 'like', "%{$this->search}%")
            ->get();

        return view('livewire.projects.position-selection-create', [
            'positions' => $filteredPositions,
        ]);
    }
}

