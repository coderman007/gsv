<?php

namespace App\Livewire\Resources\CommercialPolicies;

use App\Models\CommercialPolicy;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Illuminate\View\View;

class CommercialPolicyList extends Component
{
    use WithPagination;

    public $search = '';  // Campo de búsqueda
    public $sortBy = 'name';  // Campo para ordenar
    public $sortDirection = 'asc';  // Dirección de orden
    public $perPage = 10;  // Número de resultados por página

    // Definición del mapeo de traducciones para las políticas comerciales
    protected $policyTranslations = [
        'internal_commissions' => 'Comisiones Internas',
        'external_commissions' => 'Comisiones Externas',
        'margin' => 'Margen',
        'discount' => 'Descuento',
    ];
    public function updatingSearch(): void
    {
        // Reinicia la paginación cuando se actualiza la búsqueda
        $this->resetPage();
    }

    public function order($sort): void
    {
        // Cambia la dirección de orden o ajusta el campo de orden
        if ($this->sortBy == $sort) {
            $this->sortDirection = ($this->sortDirection == "desc") ? "asc" : "desc";
        } else {
            $this->sortBy = $sort;
            $this->sortDirection = "asc";
        }
    }

    public function getCommercialPoliciesProperty(): LengthAwarePaginator
    {
        return CommercialPolicy::where('name', 'like', '%' . $this->search . '%')  // Buscar por nombre
        ->orderBy($this->sortBy, $this->sortDirection)  // Ordenar por campo
        ->paginate($this->perPage);  // Paginación
    }

    // Escuchar eventos relacionados con políticas comerciales
    #[On('createdCommercialPolicy')]
    public function onCreatedCommercialPolicy(): void
    {
        // Reinicia la paginación para incluir el nuevo elemento
        $this->resetPage();
    }

    #[On('updatedCommercialPolicy')]
    public function onUpdatedCommercialPolicy(): void
    {
        // Acción después de la actualización de una política comercial
    }

    #[On('deletedCommercialPolicy')]
    public function onDeletedCommercialPolicy(): void
    {
        // Acción después de la eliminación de una política comercial
    }

    public function render(): View
    {
        return view('livewire.resources.commercial-policies.commercial-policy-list');
    }
}
