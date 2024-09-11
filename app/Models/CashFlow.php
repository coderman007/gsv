<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CashFlow extends Model
{
    protected $fillable = [
        'quotation_id',
        'power_output',
        'capex',
        'energy_cost',
        'energy_generated_annual',
        'energy_generated_monthly',
        'income_autoconsumption',
        'tax_discount',
        'accelerated_depreciation',
        'opex',
        'maintenance_cost',
        'cash_flow',
        'accumulated_cash_flow',
    ];

    public function quotation(): BelongsTo
    {
        return $this->belongsTo(Quotation::class);
    }

    /**
     * Cargar las variables macroeconómicas más recientes.
     */
    public function loadMacroEconomicVariables(): array
    {
        $variables = MacroEconomicVariable::orderBy('effective_date', 'desc')->pluck('value', 'name')->toArray();

        return [
            'Índice de Precios al Consumidor (IPC)'  => $variables['Índice de Precios al Consumidor (IPC)'],  // Índice de Precios al Consumidor (5% anual por defecto)
            'Impuesto sobre la Renta (IR)'   => $variables['Impuesto sobre la Renta (IR)'],   // Impuesto sobre la Renta (35% anual)
            'Incremento Anual Costo Energía (IACE)' => $variables['Incremento Anual Costo Energía (IACE)'], // Incremento Anual Costo Energía (8% anual)
            'Pérdida Eficiencia Sistema Fotovoltaico (PESF)' => $variables['Pérdida Eficiencia Sistema Fotovoltaico (PESF)'], // Pérdida de Eficiencia Sistema Fotovoltaico (0.5% anual)
            'Costo Mantenimiento Anual (CMA)'  => $variables['Costo Mantenimiento Anual (CMA)'],  // Costo Mantenimiento Anual (2% sobre CAPEX)
        ];

//        return [
//            'Índice de Precios al Consumidor (IPC)'  => $variables['Índice de Precios al Consumidor (IPC)'] ?? 0.05,  // Índice de Precios al Consumidor (5% anual por defecto)
//            'Impuesto sobre la Renta (IR)'   => $variables['Impuesto sobre la Renta (IR)'] ?? 0.35,   // Impuesto sobre la Renta (35% anual)
//            'Incremento Anual Costo Energía (IACE)' => $variables['Incremento Anual Costo Energía (IACE)'] ?? 0.08, // Incremento Anual Costo Energía (8% anual)
//            'Pérdida Eficiencia Sistema Fotovoltaico (PESF)' => $variables['Pérdida Eficiencia Sistema Fotovoltaico (PESF)'] ?? 0.005, // Pérdida de Eficiencia Sistema Fotovoltaico (0.5% anual)
//            'Costo Mantenimiento Anual (CMA)'  => $variables['Costo Mantenimiento Anual (CMA)'] ?? 0.02,  // Costo Mantenimiento Anual (2% sobre CAPEX)
//        ];
    }

}
