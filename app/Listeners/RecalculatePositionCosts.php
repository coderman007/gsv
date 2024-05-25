<?php

namespace App\Listeners;

use App\Events\PositionUpdated;

class RecalculatePositionCosts
{
    /**
     * Handle the event.
     */
    public function handle(PositionUpdated $event): void
    {
        $position = $event->position;

        // Recorrer todos los proyectos asociados con esta posición de trabajo
        $projects = $position->projects;

        foreach ($projects as $project) {
            // Obtener todas las posiciones de trabajo asociadas con este proyecto
            $positionsInProject = $project->positions;

            // Calcular el costo total de la mano de obra para este proyecto
            $totalLaborCost = 0;

            foreach ($positionsInProject as $pos) {
                // Obtener los detalles de cada posición en este proyecto
                $pivotData = $pos->pivot;

                $quantity = $pivotData->quantity;
                $requiredDays = $pivotData->required_days;
                $efficiency = $pivotData->efficiency;

                // Calcular el costo total de esta posición en este proyecto
                $positionCost = $pos->real_daily_cost * $quantity * $requiredDays * $efficiency;

                // Actualizar el costo total en la tabla pivote si es la posición modificada
                if ($pos->id === $position->id) {
                    $positionCost = $position->real_daily_cost * $quantity * $requiredDays * $efficiency;
                }
                $pivotData->update(['total_cost' => $positionCost]);

                // Sumar el costo total de esta posición al costo total de mano de obra del proyecto
                $totalLaborCost += $positionCost;
            }
            // Actualizar el costo total de herramientas del proyecto
            $project->update(['total_labor_cost' => $totalLaborCost]);

            // Actualizar el costo total del proyecto
            $project->updateTotalCost();
        }
    }
}
