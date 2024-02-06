<?php

namespace App\Livewire\ProjectTypes;

use Livewire\Component;
use App\Models\ProjectType;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class ProjectTypeList extends Component
{
    use WithPagination;

    public $search = '';
    public $sortBy = 'id';
    public $sortDirection = 'asc';
    public $perSearch = 10;

    public function mount()
    {
        $this->sortBy = 'id'; // Asegúrate de inicializar correctamente el campo de ordenación
    }

    public function updatedSearch()
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
    public function projectTypes()
    {
        return ProjectType::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('description', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perSearch);
    }

    #[On('createdProjectType')]
    public function createdProjectType($projectType = null)
    {
    }

    #[On('updatedProjectType')]
    public function updatedProjectType($projectType = null)
    {
    }

    #[On('deletedProjectType')]
    public function deletedProjectType($projectType = null)
    {
    }

    public function render()
    {
        $types = $this->projectTypes();
        return view('livewire.project-types.project-type-list', compact('types'));
    }
}
