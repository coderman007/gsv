<?php

namespace App\Observers;

use App\Models\Project;

class LaborCostObserver
{
    /**
     * Handle the Project "created" event.
     */
    public function created(Project $project): void
    {
        //
    }

    /**
     * Handle the Project "updated" event.
     */
    public function updated(Project $project)
    {
        // Calcular el nuevo costo total parcial de las herramientas
        $totalLaborCost = $project->total_labor_cost;
        $totalToolCost = $totalLaborCost * 0.05;

        // Actualizar el modelo Project con el nuevo valor calculado
        $project->total_tools_cost = $totalToolCost;
        $project->save();
    }

    /**
     * Handle the Project "deleted" event.
     */
    public function deleted(Project $project): void
    {
        //
    }

    /**
     * Handle the Project "restored" event.
     */
    public function restored(Project $project): void
    {
        //
    }

    /**
     * Handle the Project "force deleted" event.
     */
    public function forceDeleted(Project $project): void
    {
        //
    }
}
