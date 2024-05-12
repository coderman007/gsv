<?php

namespace App\Livewire\Projects;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;
use LaravelIdea\Helper\App\Models\_IH_Project_C;
use Livewire\Component;
use App\Models\Project;
use App\Models\ProjectCategory; // Agrega esta línea
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class ProjectList extends Component
{
    use WithPagination;

    public $search = '';
    public $sortBy = 'id';
    public $sortDirection = 'asc';
    public $perSearch = 10;
    public $selectedCategory = null;

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

    public function render(): View
    {
        $query = Project::query();

        // Filtrar por categoría si se ha seleccionado una
        if ($this->selectedCategory) {
            $query->whereHas('projectCategory', function ($query) {
                $query->where('id', $this->selectedCategory);
            });
        }

        $projects = $query->where('id', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perSearch);

        $categories = ProjectCategory::all(); // Obtener todas las categorías

        return view('livewire.projects.project-list', [
            'projects' => $projects,
            'categories' => $categories, // Pasar las categorías a la vista
        ]);
    }

    #[Computed]
    public function projects(): array|LengthAwarePaginator|_IH_Project_C
    {
        return
            Project::where('id', 'like', '%' . $this->search . '%')
                ->orWhere('kilowatts_to_provide', 'like', '%' . $this->search . '%')
                ->orWhere('zone', 'like', '%' . $this->search . '%')
                ->orWhere('status', 'like', '%' . $this->search . '%')
                ->orderBy($this->sortBy, $this->sortDirection)
                ->paginate($this->perSearch);
    }

    #[On('createdProject')]
    public function createdProject($project = null)
    {
    }

    #[On('updatedProject')]
    public function updatedProject($project = null)
    {
    }

    #[On('deletedProject')]
    public function deletedProject($project = null)
    {
    }
}
