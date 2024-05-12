<?php

namespace App\Livewire\Resources\Materials;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;
use LaravelIdea\Helper\App\Models\_IH_Material_C;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use App\Models\Material;
use Livewire\WithPagination;

class MaterialList extends Component
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
    public function materials(): LengthAwarePaginator|array|_IH_Material_C
    {
        return Material::where('reference', 'like', '%' . $this->search . '%')
            ->orWhere('description', 'like', '%' . $this->search . '%')
            ->orWhere('unit_price', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perSearch);
    }

    #[On('createdMaterial')]
    public function createdMaterial($materialData = null)
    {
    }

    #[On('notification')]
    public function notify($message = null)
    {
    }

    #[On('updatedMaterial')]
    public function updatedMaterial($material = null)
    {
    }

    #[On('deletedMaterial')]
    public function deletedMaterial($material = null)
    {
    }

    public function render(): View
    {
        return view('livewire.resources.materials.material-list');
    }
}
