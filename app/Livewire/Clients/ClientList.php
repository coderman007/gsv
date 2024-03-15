<?php

namespace App\Livewire\Clients;

use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\Client;
use Livewire\WithPagination;

class ClientList extends Component
{
    use WithPagination;

    public $search = '';
    public $sortBy = 'id';
    public $sortDirection = 'desc';
    public $perSearch = 10;

    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function order($sort)
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
        return
            Client::where('id', 'like', '%' . $this->search . '%')
            ->orWhere('type', 'like', '%' . $this->search . '%')
            ->orWhere('name', 'like', '%' . $this->search . '%')
            ->orWhere('document', 'like', '%' . $this->search . '%')
            ->orWhere('email', 'like', '%' . $this->search . '%')
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

    public function render()
    {
        return view('livewire.clients.client-list');
    }
}
