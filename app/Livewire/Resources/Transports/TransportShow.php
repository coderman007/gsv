<?php

namespace App\Livewire\Resources\Transports;

use App\Models\Transport;
use Livewire\Component;

class TransportShow extends Component
{
    public $openShow = false;
    public $transport;

    public function mount(Transport $transport)
    {
        $this->transport = $transport;
    }

    public function render()
    {
        return view('livewire.resources.transports.transport-show');
    }
}
