<?php

namespace App\Livewire\Projects;

use App\Models\Tool;
use Livewire\Component;

class ToolSelection extends Component
{
    public $search = '';
    public $tools = [];
    public $selectedTools = [];
    public $quantities = [];
    public $totalToolCost = 0;
    public $formattedTotalToolCost;

    protected $rules = [
        'selectedTools' => 'required|array|min:1',
        'selectedTools.*' => 'exists:tools,id',
        'quantities.*' => 'nullable|numeric|min:0',
    ];

    public function updatedSearch()
    {
        $this->tools = Tool::where('name', 'like', '%' . $this->search . '%')->get();
    }

    public function updatedQuantities()
    {
        $this->calculateTotalToolCost();
    }

    public function calculateTotalToolCost()
    {
        $totalCost = 0;
        foreach ($this->selectedTools as $toolId) {
            $quantity = $this->quantities[$toolId] ?? 0;
            $tool = Tool::find($toolId);
            $totalCost += $quantity * $tool->unit_price_per_day;
        }
        $this->totalToolCost = $totalCost;
        $this->formattedTotalToolCost = number_format($totalCost, 2);
    }

    public function sendTotalToolCost()
    {
        $this->dispatch('totalToolCostUpdated', $this->totalToolCost);

        if ($this->totalToolCost > 0) {
            $this->dispatch('hideResourceForm');
        }
    }

    public function render()
    {
        if (!empty($this->search)) {
            $this->tools = Tool::where('name', 'like', '%' . $this->search . '%')->get();
        }
        return view('livewire.projects.tool-selection');
    }
}
