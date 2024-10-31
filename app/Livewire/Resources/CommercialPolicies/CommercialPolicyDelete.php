<?php

namespace App\Livewire\Resources\CommercialPolicies;

use App\Models\CommercialPolicy;
use Illuminate\View\View;
use Livewire\Component;

class CommercialPolicyDelete extends Component
{
    public $openDelete = false;  // Controla si el diálogo de eliminación está abierto
    public $commercialPolicy;  // Política comercial a eliminar

    public function mount(CommercialPolicy $commercialPolicy): void
    {
        // Cargar la política comercial para eliminación
        $this->commercialPolicy = $commercialPolicy;
    }

    public function deleteCommercialPolicy(): void
    {
        // Obtener el usuario autenticado
        $user = auth()->user();

        // Verificar si el usuario tiene permisos para actualizar la categoría
        if (!$user || (!$user->hasRole('Administrador'))) {
            abort(403, 'No está autorizado para llevar a cabo esta acción.');
            return;
        }

        // Eliminar la política comercial
        if ($this->commercialPolicy) {
            $this->commercialPolicy->delete();  // Eliminar el registro

            // Emitir eventos para notificar sobre la eliminación exitosa
            $this->dispatch('deletedCommercialPolicy', $this->commercialPolicy);
            $this->dispatch('deletedCommercialPolicyNotification');

            // Cerrar el diálogo de eliminación
            $this->openDelete = false;
        }
    }

    public function render(): View
    {
        return view('livewire.resources.commercial-policies.commercial-policy-delete');
    }
}
