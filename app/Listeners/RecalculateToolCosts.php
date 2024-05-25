<?php

namespace App\Listeners;

use App\Events\ToolUpdated;

class RecalculateToolCosts
{
    public function handle(ToolUpdated $event): void
    {
        $tool = $event->tool;

        // Recorrer todos los proyectos asociados con esta herramienta
        $projects = $tool->projects;

        foreach ($projects as $project) {
            // Obtener todas las herramientas asociadas con este proyecto
            $toolsInProject = $project->tools;

            // Calcular el costo total de las herramientas para este proyecto
            $totalToolCost = 0;

            foreach ($toolsInProject as $tool) {
                // Obtener los detalles de cada herramienta en este proyecto
                $pivotData = $tool->pivot;

                $quantity = $pivotData->quantity;
                $requiredDays = $pivotData->required_days;
                $efficiency = $pivotData->efficiency;

                // Calcular el costo total de esta herramienta en este proyecto
                $toolCost = $tool->unit_price_per_day * $quantity * $requiredDays * $efficiency;

                // Actualizar el costo total en la tabla pivote
                $pivotData->update(['total_cost' => $toolCost]);

                // Sumar el costo total de esta herramienta al costo total de herramientas del proyecto
                $totalToolCost += $toolCost;
            }

            // Actualizar el costo total de herramientas del proyecto
            $project->update(['total_tool_cost' => $totalToolCost]);

            // Actualizar el costo total del proyecto
            $project->updateTotalCost();
        }
    }
}


