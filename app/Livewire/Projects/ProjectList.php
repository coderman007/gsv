<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use App\Models\ProjectCategory;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\View\View;
use LaravelIdea\Helper\App\Models\_IH_Project_C;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

// Agrega esta línea

/**
 * @property array|LengthAwarePaginator|\Illuminate\Pagination\LengthAwarePaginator|_IH_Project_C|mixed|null $projects
 */
class ProjectList extends Component
{
    use WithPagination;

    public $search = '';
    public $sortBy = 'id';
    public $sortDirection = 'desc';
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

    #[Computed]
    public function projects(): LengthAwarePaginator|array|\Illuminate\Pagination\LengthAwarePaginator|_IH_Project_C
    {
        $query = Project::query();

        // Filtrar por categoría si se ha seleccionado una
        if ($this->selectedCategory) {
            $query->where('project_category_id', $this->selectedCategory);
        }

        return $query->where(function ($query) {
            $query->where('id', 'like', '%' . $this->search . '%')
                ->orWhere('zone', 'like', '%' . $this->search . '%')
                ->orWhere('status', 'like', '%' . $this->search . '%');
        })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perSearch);
    }

    public function render(): View
    {
        $categories = ProjectCategory::all();

        return view('livewire.projects.project-list', [
            'projects' => $this->projects(),
            'categories' => $categories,
        ]);
    }


    #[On('createdProject')]
    public function createdProject($project = null)
    {
    }

    #[On('updatedProject')]
    public function updatedProject($project = null): void
    {
        // Actualizar el costo total del proyecto
        $project->updateTotalCost();
    }

    #[On('deletedProject')]
    public function deletedProject($project = null)
    {
    }

}
