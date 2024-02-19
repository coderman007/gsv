<?php

namespace App\Livewire\Resources\Tools;

use App\Models\Tool;
use Livewire\Component;

class ToolCreate extends Component
{
    public $openCreate = false;
    public $category, $name, $unitPrice;

    protected $rules = [
        'category' => 'required|string|max:255',
        'name' => 'required|string|max:255',
        'unitPrice' => 'required|numeric|min:0',
    ];

    public function createTool()
    {
        $this->validate();

        $tool = Tool::create([
            'category' => $this->category,
            'name' => $this->name,
            'unit_price' => $this->unitPrice,
        ]);

        $this->openCreate = false;
        $this->dispatch('createdTool', $tool);
        $this->dispatch('createdToolNotification');
        $this->reset('category', 'name', 'unitPrice');
    }

    public function render()
    {
        return view('livewire.resources.tools.tool-create');
    }
}
