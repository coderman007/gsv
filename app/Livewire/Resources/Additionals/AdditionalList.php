<?php

namespace App\Livewire\Resources\Additionals;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;
use LaravelIdea\Helper\App\Models\_IH_Material_C;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use App\Models\Additional;
use Livewire\WithPagination;

/**
 * @property array|LengthAwarePaginator|_IH_Material_C|mixed|null $additionals
 */
class AdditionalList extends Component
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
    public function additionals(): LengthAwarePaginator|array|_IH_Material_C
    {
        return Additional::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('description', 'like', '%' . $this->search . '%')
            ->orWhere('unit_price', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perSearch);
    }

    #[On('createdAdditional')]
    public function createdAdditional($additionalData = null)
    {
    }

    #[On('notification')]
    public function notify($message = null)
    {
    }

    #[On('updatedAdditional')]
    public function updatedAdditional($additional = null)
    {
    }

    #[On('deletedAdditional')]
    public function deletedAdditional($additional = null)
    {
    }

    public function render(): View
    {
        return view('livewire.resources.additionals.additional-list');
    }
}
