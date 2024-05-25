<?php

namespace App\Listeners;

use App\Events\MaterialUpdated;

class RecalculateMaterialCosts
{
    public function handle(MaterialUpdated $event): void
    {
        $material = $event->material;

        // Recorrer todos los proyectos asociados con este material
        $projects = $material->projects;

        foreach ($projects as $project) {
            // Obtener todos los materiales asociados con este proyecto
            $materialsInProject = $project->materials;

            // Calcular el costo total de los materiales para este proyecto
            $totalMaterialCost = 0;

            foreach ($materialsInProject as $material) {
                // Obtener los detalles de cada material en este proyecto
                $pivotData = $material->pivot;

                $quantity = $pivotData->quantity;
                $efficiency = $pivotData->efficiency;

                // Calcular el costo total de este material en este proyecto
                $materialCost = $material->unit_price * $quantity * $efficiency;

                // Actualizar el costo total en la tabla pivote
                $pivotData->update(['total_cost' => $materialCost]);

                // Sumar el costo total de este material al costo total de materiales del proyecto
                $totalMaterialCost += $materialCost;
            }

            // Actualizar el costo total de materiales del proyecto
            $project->update(['total_material_cost' => $totalMaterialCost]);

            // Actualizar el costo total del proyecto
            $project->updateTotalCost();
        }
    }
}

