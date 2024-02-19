<?php

namespace App\Livewire\Resources\Materials;

use Livewire\Component;
use App\Models\Material;
use Livewire\Attributes\On;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;

class MaterialList extends Component
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
    public function materials()
    {
        return Material::where('category', 'like', '%' . $this->search . '%')
            ->orWhere('reference', 'like', '%' . $this->search . '%')
            ->orWhere('description', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perSearch);
    }

    #[On('createdMaterial')]
    public function createdMaterial($material = null)
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

    public function render()
    {
        $materials = $this->materials();
        return view('livewire.resources.materials.material-list', compact('materials'));
    }
}
