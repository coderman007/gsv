<?php

namespace App\Listeners;

use App\Events\TransportUpdated;

class RecalculateTransportCosts
{
    public function handle(TransportUpdated $event): void
    {
        $transport = $event->transport;

        // Recorrer todos los proyectos asociados con este transporte
        $projects = $transport->projects;

        foreach ($projects as $project) {
            // Obtener todos los transportes asociados con este proyecto
            $transportsInProject = $project->transports;

            // Calcular el costo total de los transportes para este proyecto
            $totalTransportCost = 0;

            foreach ($transportsInProject as $transport) {
                // Obtener los detalles de cada transporte en este proyecto
                $pivotData = $transport->pivot;

                $quantity = $pivotData->quantity;
                $requiredDays = $pivotData->required_days;
                $efficiency = $pivotData->efficiency;

                // Calcular el costo total de este transporte en este proyecto
                $transportCost = $transport->cost_per_day * $quantity * $requiredDays * $efficiency;

                // Actualizar el costo total en la tabla pivote
                $pivotData->update(['total_cost' => $transportCost]);

                // Sumar el costo total de este transporte al costo total de transportes del proyecto
                $totalTransportCost += $transportCost;
            }

            // Actualizar el costo total de transportes del proyecto
            $project->update(['total_transport_cost' => $totalTransportCost]);

            // Actualizar el costo total del proyecto
            $project->updateTotalCost();
        }
    }
}

