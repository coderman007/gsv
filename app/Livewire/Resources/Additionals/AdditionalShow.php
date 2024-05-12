<?php

namespace App\Livewire\Resources\Additionals;

use App\Models\Additional;
use Illuminate\View\View;
use Livewire\Component;

class AdditionalShow extends Component
{
    public $openShow = false;
    public $additional;

    public function mount(Additional $additional): void
    {
        $this->additional = $additional;
    }

    public function render(): View
    {
        return view('livewire.resources.additionals.additional-show');
    }
}
