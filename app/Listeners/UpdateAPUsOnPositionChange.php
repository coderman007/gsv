<?php

namespace App\Listeners;

use App\Events\PositionUpdated;
use App\Models\Project;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateAPUsOnPositionChange
{
    public function __construct()
    {
        //
    }

    public function handle(PositionUpdated $event): void
    {
        $position = $event->position;

        // Obtener todos los proyectos asociados con la posición actualizada
        $projects = Project::whereHas('positions', function ($query) use ($position) {
            $query->where('position_id', $position->id);
        })->get();

        foreach ($projects as $project) {
            // Recalcular y actualizar el costo total del proyecto
            if($project->calculateTotalCost()){
                dd('Proof');
            }
        }
    }
}
