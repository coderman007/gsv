<?php

namespace App\Livewire;

use Livewire\Component;

class Notification extends Component
{

    public function save()
    {
        $this->dispatch('swal', [
            'title' => 'Success',
            'text' => 'Cliente Creado Exitosamente!',
            'icon' => 'success'
        ]);
    }
    public function render()
    {
        return view('livewire.notification');
    }
}
