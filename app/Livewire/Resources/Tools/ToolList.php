<?php

namespace App\Livewire\Resources\Tools;

use Livewire\Component;
use App\Models\Tool;
use Livewire\Attributes\On;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;

class ToolList extends Component
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
    public function tools()
    {
        return Tool::where('name', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perSearch);
    }

    #[On('createdTool')]
    public function createdTool($tool = null)
    {
    }

    #[On('updatedTool')]
    public function updatedTool($tool = null)
    {
    }

    #[On('deletedTool')]
    public function deletedTool($tool = null)
    {
    }

    public function render()
    {
        $tools = $this->tools();
        return view('livewire.resources.tools.tool-list', compact('tools'));
    }
}
