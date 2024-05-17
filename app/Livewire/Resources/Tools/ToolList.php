<?php

namespace App\Livewire\Resources\Tools;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;
use LaravelIdea\Helper\App\Models\_IH_Tool_C;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use App\Models\Tool;
use Livewire\WithPagination;

/**
 * @property array|LengthAwarePaginator|_IH_Tool_C|mixed|null $tools
 */
class ToolList extends Component
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
    public function tools(): _IH_Tool_C|LengthAwarePaginator|array
    {
        return Tool::where('name', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perSearch);
    }

    #[On('createdTool')]
    public function createdTool($toolData = null)
    {
    }

    #[On('notification')]
    public function notify($message = null)
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

    public function render(): View
    {
        return view('livewire.resources.tools.tool-list');
    }
}
