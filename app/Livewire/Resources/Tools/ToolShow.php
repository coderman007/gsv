<?php

namespace App\Livewire\Resources\Tools;

use App\Models\Tool;
use Illuminate\View\View;
use Livewire\Component;

class ToolShow extends Component
{
    public $openShow = false;
    public $tool;

    public function mount(Tool $tool): void
    {
        $this->tool = $tool;
    }

    public function render(): View
    {
        return view('livewire.resources.tools.tool-show');
    }
}
