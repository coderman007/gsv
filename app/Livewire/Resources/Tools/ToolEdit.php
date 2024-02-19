<?php

namespace App\Livewire\Resources\Tools;

use App\Models\Tool;
use Livewire\Component;

class ToolEdit extends Component
{
    public $openEdit = false;
    public $toolId;
    public $category, $name, $unitPrice;
    public $tool;

    protected $rules = [
        'category' => 'required|min:5|max:255',
        'name' => 'required|min:5|max:255',
        'unitPrice' => 'required|numeric|min:0',
    ];

    public function mount($toolId)
    {
        try {
            $this->toolId = $toolId;
            $this->tool = Tool::findOrFail($toolId);
            $this->category = $this->tool->category;
            $this->name = $this->tool->name;
            $this->unitPrice = $this->tool->unit_price;
        } catch (\Exception $exception) {
            abort(404, ['Herramienta no encontrada', $exception->getMessage()]);
        }
    }

    public function updateTool()
    {
        $this->validate();

        $tool = Tool::findOrFail($this->toolId);

        $tool->update([
            'category' => $this->category,
            'name' => $this->name,
            'unit_price' => $this->unitPrice,
        ]);

        $this->openEdit = false;
        $this->dispatch('updatedTool', $tool);
        $this->dispatch('updatedToolNotification');
    }

    public function render()
    {
        return view('livewire.resources.tools.tool-edit');
    }
}
