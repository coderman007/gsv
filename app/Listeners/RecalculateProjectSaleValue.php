<?php

namespace App\Listeners;

use App\Events\CommercialPolicyUpdated;
use App\Models\Project;

class RecalculateProjectSaleValue
{
    /**
     * Handle the event.
     */
    public function handle(CommercialPolicyUpdated $event): void
    {
        // Obtener todos los proyectos
        $projects = Project::all();

        foreach ($projects as $project) {
            // Actualizar el costo total del proyecto
            $project->updateTotalCost();
        }
    }
}
