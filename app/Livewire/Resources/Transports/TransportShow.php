<?php

namespace App\Livewire\Resources\Transports;

use App\Models\Transport;
use Illuminate\View\View;
use Livewire\Component;

class TransportShow extends Component
{
    public $openShow = false;
    public $transport;

    public function mount(Transport $transport): void
    {
        $this->transport = $transport;
    }

    public function render(): View
    {
        return view('livewire.resources.transports.transport-show');
    }
}

