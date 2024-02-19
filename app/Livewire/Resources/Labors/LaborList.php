<?php

namespace App\Livewire\Resources\Labors;

use Livewire\Component;
use App\Models\Labor;
use Livewire\Attributes\On;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;

class LaborList extends Component
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
    public function labors()
    {
        return Labor::where('position', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perSearch);
    }

    #[On('createdLabor')]
    public function createdLabor($labor = null)
    {
    }

    #[On('updatedLabor')]
    public function updatedLabor($labor = null)
    {
    }

    #[On('deletedLabor')]
    public function deletedLabor($labor = null)
    {
    }

    public function render()
    {
        $labors = $this->labors();
        return view('livewire.resources.labors.labor-list', compact('labors'));
    }
}
