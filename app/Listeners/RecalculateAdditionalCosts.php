<?php

namespace App\Listeners;

use App\Events\AdditionalUpdated;

class RecalculateAdditionalCosts
{
    public function handle(AdditionalUpdated $event): void
    {
        $additional = $event->additional;

        // Recorrer todos los proyectos asociados con este adicional
        $projects = $additional->projects;

        foreach ($projects as $project) {
            // Obtener todos los adicionales asociados con este proyecto
            $additionalsInProject = $project->additionals;

            // Calcular el costo total de los adicionales para este proyecto
            $totalAdditionalCost = 0;

            foreach ($additionalsInProject as $additional) {
                // Obtener los detalles de cada adicional en este proyecto
                $pivotData = $additional->pivot;

                $quantity = $pivotData->quantity;
                $efficiency = $pivotData->efficiency;

                // Calcular el costo total de este adicional en este proyecto
                $additionalCost = $additional->unit_price * $quantity * $efficiency;

                // Actualizar el costo total en la tabla pivote
                $pivotData->update(['total_cost' => $additionalCost]);

                // Sumar el costo total de este adicional al costo total de adicionales del proyecto
                $totalAdditionalCost += $additionalCost;
            }

            // Actualizar el costo total de adicionales del proyecto
            $project->update(['total_additional_cost' => $totalAdditionalCost]);

            // Actualizar el costo total del proyecto
            $project->updateTotalCost();
        }
    }
}
