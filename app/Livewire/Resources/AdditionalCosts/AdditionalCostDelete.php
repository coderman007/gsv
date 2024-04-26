<?php

namespace App\Livewire\Resources\AdditionalCosts;

use App\Models\AdditionalCost;
use Illuminate\View\View;
use Livewire\Component;

class AdditionalCostDelete extends Component
{
    public $openDelete = false;
    public $additionalCost;

    public function mount(AdditionalCost $additionalCost): void
    {
        $this->additionalCost = $additionalCost;
    }

    public function deleteAdditionalCost(): void
    {
        // Verificar si el usuario autenticado existe
        if (!auth()->check()) {
            abort(403, 'No está autorizado para llevar a cabo esta acción.');
        }

        // Verificar si el usuario autenticado tiene el rol 'Administrador' y está activo
        if (!auth()->user()->hasRole('Administrador') || auth()->user()->status !== 'Activo') {
            abort(403, 'No está autorizado para llevar a cabo esta acción.');
        }

        // Si el costo adicional a eliminar existe, proceder con la eliminación
        if ($this->additionalCost) {
            $additionalCost = $this->additionalCost->delete();
            $this->dispatch('deletedAdditionalCost', $additionalCost);
            $this->dispatch('deletedAdditionalCostNotification');
            $this->openDelete = false;
        }
    }

    public function render(): View
    {
        return view('livewire.resources.additional-costs.additional-cost-delete');
    }
}
