<?php

namespace App\Livewire\Resources\Transports;

use Livewire\Component;
use App\Models\Transport;
use Livewire\Attributes\On;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;

class TransportList extends Component
{
    use WithPagination;

    public $search = '';
    public $sortBy = 'id';
    public $sortDirection = 'asc';
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

        $this->resetPage();
    }

    #[Computed]
    public function transports()
    {
        return Transport::where('vehicle_type', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perSearch);
    }

    #[On('createdTransport')]
    public function createdTransport($transport = null)
    {
    }

    #[On('updatedTransport')]
    public function updatedTransport($transport = null)
    {
    }

    #[On('deletedTransport')]
    public function deletedTransport($transport = null)
    {
    }

    public function render()
    {
        $transports = $this->transports();
        return view('livewire.resources.transports.transport-list', compact('transports'));
    }
}
