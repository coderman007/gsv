<?php

namespace App\Livewire\Resources\CommercialPolicies;

use App\Models\CommercialPolicy;
use Livewire\Component;
use Illuminate\View\View;

class CommercialPolicyEdit extends Component
{
    public $commercialPolicyId;  // ID de la política comercial a editar
    public $openEdit = false;  // Controla si el formulario está abierto
    public $name;  // Campo para el nombre de la política
    public $percentage;  // Campo para el porcentaje de la política

    protected $rules = [
        'name' => 'required|string|max:255',  // El nombre debe ser obligatorio
        'percentage' => 'required|numeric|between:0,100',  // El porcentaje debe ser entre 0 y 100
    ];

    public function mount($commercialPolicyId): void
    {
        // Cargar la política comercial para editar
        $this->commercialPolicyId = $commercialPolicyId;
        $policy = CommercialPolicy::findOrFail($this->commercialPolicyId);

        // Asignar valores a las propiedades para la edición
        $this->name = $policy->name;
        $this->percentage = $policy->percentage;
    }

    public function updateCommercialPolicy(): void
    {
        // Obtener el usuario autenticado
        $user = auth()->user();

        // Verificar si el usuario tiene permisos para actualizar la categoría
        if (!$user || (!$user->hasRole('Administrador'))) {
            abort(403, 'No está autorizado para llevar a cabo esta acción.');
            return;
        }

        // Validar los datos antes de actualizar
        $this->validate();

        // Encontrar y actualizar la política comercial
        $policy = CommercialPolicy::findOrFail($this->commercialPolicyId);
        $policy->update([
            'name' => $this->name,
            'percentage' => $this->percentage,
        ]);

        // Emitir eventos para notificar sobre la actualización
        $this->dispatch('updatedCommercialPolicy', $policy);  // Evento para otros componentes
        $this->dispatch('updatedCommercialPolicyNotification', [
            'message' => 'Política comercial actualizada con éxito',
        ]);

        // Cerrar el formulario de edición
        $this->openEdit = false;
    }

    public function render(): View
    {
        return view('livewire.resources.commercial-policies.commercial-policy-edit');
    }
}
