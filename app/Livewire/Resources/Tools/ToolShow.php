<?php

namespace App\Livewire\Resources\Tools;

use App\Models\Tool;
use Livewire\Component;

class ToolShow extends Component
{
    public $openShow = false;
    public $tool;

    public function mount(Tool $tool)
    {
        $this->tool = $tool;
    }

    public function render()
    {
        return view('livewire.resources.tools.tool-show');
    }
}
