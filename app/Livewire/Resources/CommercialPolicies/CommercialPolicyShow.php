<?php

namespace App\Livewire\Resources\CommercialPolicies;

use App\Models\CommercialPolicy;
use Illuminate\View\View;
use Livewire\Component;

class CommercialPolicyShow extends Component
{
    public $openShow = false;  // Controla si el componente de detalle está abierto
    public $commercialPolicy;  // Política comercial a mostrar

    public function mount(CommercialPolicy $commercialPolicy): void
    {
        // Cargar la política comercial para mostrar detalles
        $this->commercialPolicy = $commercialPolicy;
    }

    public function render(): View
    {
        return view('livewire.resources.commercial-policies.commercial-policy-show');
    }
}
