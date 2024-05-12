<?php

namespace App\Livewire\Resources\CommercialPolicies;

use App\Models\CommercialPolicy;
use Illuminate\View\View;
use Livewire\Component;

class CommercialPolicyCreate extends Component
{
    public $openCreate = false;  // Controla si el formulario está abierto
    public $name;  // Nombre de la política
    public $percentage;  // Porcentaje de la política

    // Reglas de validación para los campos
    protected $rules = [
        'name' => 'required|string|max:255',  // El nombre es obligatorio
        'percentage' => 'required|numeric|between:0,100',  // El porcentaje debe ser entre 0 y 100
    ];

    // Método para crear una nueva política comercial
    public function createCommercialPolicy(): void
    {
        // Validar datos antes de crear
        $this->validate();

        // Crear la nueva política comercial
        $policy = CommercialPolicy::create([
            'name' => $this->name,
            'percentage' => $this->percentage,
        ]);

        // Cerrar el formulario de creación
        $this->openCreate = false;

        // Emitir eventos para notificar sobre la creación exitosa
        $this->dispatch('createdCommercialPolicy', $policy);  // Para otros componentes
        $this->dispatch('createdCommercialPolicyNotification');

        // Restablecer los campos después de la creación
        $this->reset();
    }

    // Método para renderizar la vista
    public function render(): View
    {
        return view('livewire.resources.commercial-policies.commercial-policy-create');
    }
}

