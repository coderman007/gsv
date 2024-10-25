<?php

namespace App\Livewire\Clients;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;
use LaravelIdea\Helper\App\Models\_IH_Client_C;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use App\Models\Client;
use Livewire\WithPagination;

/**
 * @property Client[]|LengthAwarePaginator|_IH_Client_C|mixed|null $clients
 */
class ClientList extends Component
{
    use WithPagination;

    public $search = '';
    public $sortBy = 'id';
    public $sortDirection = 'desc';
    public $perSearch = 10;

    public function updatingSearch(): void
    {
        $this->resetPage();
    }
    public function order($sort): void
    {
        if ($this->sortBy == $sort) {
            $this->sortDirection = ($this->sortDirection == "desc") ? "asc" : "desc";
        } else {
            $this->sortBy = $sort;
            $this->sortDirection = "asc";
        }
    }
    #[Computed()]
    public function clients()
    {
        $query = Client::query();

        // Obtener el usuario autenticado
        $user = auth()->user();

        // Validar el rol utilizando el método `hasRole` de Spatie
        if ($user->hasRole('Vendedor')) {
            $query->where('user_id', $user->id); // Filtrar por `user_id` si el usuario es vendedor
        }

        // Aplicar filtros de búsqueda y ordenamiento
        return $query->where(function ($q) {
            $q->where('id', 'like', '%' . $this->search . '%')
                ->orWhere('type', 'like', '%' . $this->search . '%')
                ->orWhere('name', 'like', '%' . $this->search . '%')
                ->orWhere('document', 'like', '%' . $this->search . '%')
                ->orWhere('email', 'like', '%' . $this->search . '%');
        })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perSearch);
    }


    #[On('createdClient')]
    public function createdClient($clientData = null)
    {
    }

    #[On('notification')]
    public function notify($message = null)
    {
    }

    #[On('updatedClient')]
    public function updatedClient($client = null)
    {
    }

    #[On('deletedClient')]
    public function deletedClient($client = null)
    {
    }

    public function render():View
    {
        return view('livewire.clients.client-list');
    }
}
