<?php

namespace App\Livewire\Resources\Transports;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;
use LaravelIdea\Helper\App\Models\_IH_Transport_C;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use App\Models\Transport;
use Livewire\WithPagination;

/**
 * @property array|LengthAwarePaginator|_IH_Transport_C|mixed|null $transports
 */
class TransportList extends Component
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

    #[Computed]
    public function transports(): array|LengthAwarePaginator|_IH_Transport_C
    {
        return Transport::where('vehicle_type', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perSearch);
    }

    #[On('createdTransport')]
    public function createdTransport($toolData = null)
    {
    }

    #[On('notification')]
    public function notify($message = null)
    {
    }

    #[On('updatedTransport')]
    public function updatedTransport($tool = null)
    {
    }

    #[On('deletedTransport')]
    public function deletedTransport($tool = null)
    {
    }

    public function render(): View
    {
        return view('livewire.resources.transports.transport-list');
    }
}
