<?php

namespace App\Livewire\Layouts;

use Illuminate\View\View;
use Livewire\Component;

class LayoutList extends Component
{
    public function render(): View
    {
        return view('livewire.layouts.layout-list');
    }
}
