<?php

namespace App\Livewire\Resources\AdditionalCosts;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;
use LaravelIdea\Helper\App\Models\_IH_Material_C;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use App\Models\AdditionalCost;
use Livewire\WithPagination;

class AdditionalCostList extends Component
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
    public function additionalCosts(): LengthAwarePaginator|array|_IH_Material_C
    {
        return AdditionalCost::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('description', 'like', '%' . $this->search . '%')
            ->orWhere('unit_price', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perSearch);
    }

    #[On('createdAdditionalCost')]
    public function createdAdditionalCost($additionalCostData = null)
    {
    }

    #[On('notification')]
    public function notify($message = null)
    {
    }

    #[On('updatedAdditionalCost')]
    public function updatedAdditionalCost($additionalCost = null)
    {
    }

    #[On('deletedAdditionalCost')]
    public function deletedAdditionalCost($additionalCost = null)
    {
    }

    public function render(): View
    {
        return view('livewire.resources.additional-costs.additional-cost-list');
    }
}
