<?php

namespace App\Livewire\Resources\Positions;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;
use LaravelIdea\Helper\App\Models\_IH_Position_C;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use App\Models\Position;
use Livewire\WithPagination;

class PositionList extends Component
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
    public function positions(): LengthAwarePaginator|_IH_Position_C|array
    {
        return Position::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('basic', 'like', '%' . $this->search . '%')
            ->orWhere('monthly_work_hours', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perSearch);
    }

    #[On('createdPosition')]
    public function createdPosition($positionData = null)
    {
    }

    #[On('notification')]
    public function notify($message = null)
    {
    }

    #[On('updatedPosition')]
    public function updatedPosition($position = null)
    {
    }

    #[On('deletedPosition')]
    public function deletedPosition($position = null)
    {
    }

    public function render(): View
    {
        return view('livewire.resources.positions.position-list');
    }
}
