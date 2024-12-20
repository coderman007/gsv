<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use Illuminate\View\View;
use Livewire\Component;

class ProjectDelete extends Component
{
    public $openDelete = false;
    public $project;

    public function mount(Project $project): void
    {
        $this->project = $project;
    }
    public function deleteProject(): void
    {
        // Obtener el usuario autenticado
        $user = auth()->user();

        // Verificar si el usuario tiene permisos para actualizar la categoría
        if (!$user || (!$user->hasRole('Administrador'))) {
            abort(403, 'No está autorizado para llevar a cabo esta acción.');
            return;
        }

        if ($this->project) {
            $project = $this->project->delete();
            $this->dispatch('deletedProject', $project);
            $this->dispatch('deletedProjectNotification');
            $this->openDelete = false;
        }
    }

    public function render(): View
    {
        return view('livewire.projects.project-delete');
    }
}
