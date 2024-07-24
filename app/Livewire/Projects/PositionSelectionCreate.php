<?php

namespace App\Livewire\Projects;

use App\Helpers\DataTypeConverter;
use App\Models\Position;
use Illuminate\View\View;
use Livewire\Component;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class PositionSelectionCreate extends Component
{
    public $availablePositionsCreate = [];
    public $selectedPositionsCreate = [];
    public $quantitiesPositionCreate = [];
    public $requiredDaysPositionCreate = [];
    public $efficiencyInputsPositionCreate = [];
    public $efficienciesPositionCreate = [];
    public $partialCostsPositionCreate = [];
    public $totalLaborCostCreate = 0;
    public $positionSearch = '';

    protected $rules = [
        'selectedPositionsCreate' => 'required|array|min:1',
        'selectedPositionsCreate.*' => 'exists:positions,id',
        'quantitiesPositionCreate.*' => 'nullable|numeric|min:0',
        'requiredDaysPositionCreate.*' => 'nullable|numeric|min:0',
        'efficiencyInputsPositionCreate.*' => 'nullable|string',
    ];

    /**
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
    public function mount(): void
    {
        $this->availablePositionsCreate = Position::all();
        $this->updateTotalLaborCostCreate();

        $this->selectedPositionsCreate = session()->get('selectedPositionsCreate', []);
        $this->quantitiesPositionCreate = session()->get('quantitiesPositionCreate', []);
        $this->requiredDaysPositionCreate = session()->get('requiredDaysPositionCreate', []);
        $this->efficiencyInputsPositionCreate = session()->get('efficiencyInputsPositionCreate', []);
        $this->efficienciesPositionCreate = session()->get('efficienciesPositionCreate', []);
        $this->partialCostsPositionCreate = session()->get('partialCostsPositionCreate', []);
        $this->totalLaborCostCreate = session()->get('totalLaborCostCreate', 0);
        $this->positionSearch = '';
    }

    public function dehydrate(): void
    {
        session()->put('selectedPositionsCreate', $this->selectedPositionsCreate);
        session()->put('quantitiesPositionCreate', $this->quantitiesPositionCreate);
        session()->put('requiredDaysPositionCreate', $this->requiredDaysPositionCreate);
        session()->put('efficiencyInputsPositionCreate', $this->efficiencyInputsPositionCreate);
        session()->put('efficienciesPositionCreate', $this->efficienciesPositionCreate);
        session()->put('partialCostsPositionCreate', $this->partialCostsPositionCreate);
        session()->put('totalLaborCostCreate', $this->totalLaborCostCreate);
    }

    public function addPosition($positionId): void
    {
        if (!in_array($positionId, $this->selectedPositionsCreate)) {
            $this->selectedPositionsCreate[] = $positionId;
        } else {
            $this->selectedPositionsCreate = array_merge(array_diff($this->selectedPositionsCreate, [$positionId]), [$positionId]);
        }
        $this->positionSearch = '';
        $this->updateTotalLaborCostCreate();
    }

    public function removePosition($positionId): void
    {
        $this->selectedPositionsCreate = array_diff($this->selectedPositionsCreate, [$positionId]);
        unset($this->quantitiesPositionCreate[$positionId]);
        unset($this->requiredDaysPositionCreate[$positionId]);
        unset($this->efficiencyInputsPositionCreate[$positionId]);
        unset($this->efficienciesPositionCreate[$positionId]);
        unset($this->partialCostsPositionCreate[$positionId]);
        $this->updateTotalLaborCostCreate();
    }

    public function calculatePartialCostCreate($positionId): void
    {
        $quantity = $this->quantitiesPositionCreate[$positionId] ?? 0;
        $requiredDays = $this->requiredDaysPositionCreate[$positionId] ?? 0;
        $efficiencyInput = $this->efficiencyInputsPositionCreate[$positionId] ?? "1";
        $efficiency = DataTypeConverter::convertToFloat($efficiencyInput);

        if ($efficiency === null) {
            $this->partialCostsPositionCreate[$positionId] = 0;
            $this->addError("efficiencyInputsPositionCreate_$positionId", "Entrada de rendimiento inválida: '$efficiencyInput'");
        } else {
            $position = Position::find($positionId);
            $dailyCost = $position->real_daily_cost;
            $this->partialCostsPositionCreate[$positionId] = $quantity * $requiredDays * $efficiency * $dailyCost;
        }

        $this->updateTotalLaborCostCreate();
    }

    public function updatedQuantitiesPositionCreate($value, $positionId): void
    {
        if (!is_numeric($value)) {
            $this->quantitiesPositionCreate[$positionId] = null;
            return;
        }
        $this->calculatePartialCostCreate($positionId);
        $this->updateTotalLaborCostCreate();
    }

    public function updatedRequiredDaysPositionCreate($value, $positionId): void
    {
        if (!is_numeric($value)) {
            $this->requiredDaysPositionCreate[$positionId] = null;
            return;
        }
        $this->calculatePartialCostCreate($positionId);
        $this->updateTotalLaborCostCreate();
    }

    public function updatedEfficiencyInputsPositionCreate($value, $positionId): void
    {
        $efficiency = DataTypeConverter::convertToFloat($value);

        if ($efficiency === null) {
            $this->addError("efficiencyInputsPositionCreate_$positionId", "Entrada de rendimiento inválida: '$value'");
            return;
        }
        $this->efficienciesPositionCreate[$positionId] = $efficiency;
        $this->efficiencyInputsPositionCreate[$positionId] = $value;
        $this->calculatePartialCostCreate($positionId);
        $this->updateTotalLaborCostCreate();
    }

    public function updateTotalLaborCostCreate(): void
    {
        $this->totalLaborCostCreate = array_sum($this->partialCostsPositionCreate);
    }

    public function sendTotalLaborCostCreate(): void
    {
        $this->dispatch('positionSelectionCreateUpdated', [
            'selectedPositionsCreate' => $this->selectedPositionsCreate,
            'positionQuantitiesCreate' => $this->quantitiesPositionCreate,
            'positionRequiredDaysCreate' => $this->requiredDaysPositionCreate,
            'positionEfficienciesCreate' => $this->efficienciesPositionCreate,
            'totalLaborCostCreate' => $this->totalLaborCostCreate,
        ]);

        if ($this->totalLaborCostCreate > 0) {
            $this->dispatch('hideResourceFormCreate');
        }
    }

    public function render(): View
    {
        $filteredPositions = Position::query()
            ->where('name', 'like', "%$this->positionSearch%")
            ->get();

        // Reverse the selected positions array to show the last selected at the top
        $selectedPositions = Position::whereIn('id', $this->selectedPositionsCreate)->get()->sortByDesc(function ($position) {
            return array_search($position->id, $this->selectedPositionsCreate);
        });

        return view('livewire.projects.position-selection-create', [
            'positions' => $filteredPositions,
            'selectedPositions' => $selectedPositions,
        ]);
    }
}
