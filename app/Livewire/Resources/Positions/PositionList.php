<?php

namespace App\Livewire\Resources\Positions;

use App\Models\Position;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class PositionList extends Component
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
    public function positions()
    {
        return Position::where('name', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perSearch);
    }

    #[On('createdPosition')]
    public function createdPosition($position = null)
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

    public function render()
    {
        $positions = $this->positions();
        return view('livewire.resources.positions.position-list', compact('positions'));
    }
}
