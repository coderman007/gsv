<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MacroEconomicVariable;

class MacroEconomicVariableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Índice de Precios al Consumidor (IPC)
        MacroEconomicVariable::create([
            'name' => 'Índice de Precios al Consumidor (IPC)',
            'value' => 5.0, // 5% anual por defecto
            'unit' => '%',
            'description' => 'Porcentaje de inflación anual en Colombia',
            'effective_date' => now(),
        ]);

        // Impuesto sobre la Renta (IR)
        MacroEconomicVariable::create([
            'name' => 'Impuesto sobre la Renta (IR)',
            'value' => 35.0, // 35% anual
            'unit' => '%',
            'description' => 'Impuesto anual sobre la renta en Colombia',
            'effective_date' => now(),
        ]);

        // Incremento Anual Costo Energía (IACE)
        MacroEconomicVariable::create([
            'name' => 'Incremento Anual Costo Energía (IACE)',
            'value' => 8.0, // 8% anual en Colombia
            'unit' => '%',
            'description' => 'Porcentaje de incremento anual en el costo de la energía en Colombia',
            'effective_date' => now(),
        ]);

        // Pérdida Eficiencia Sistema Fotovoltaico (PESF)
        MacroEconomicVariable::create([
            'name' => 'Pérdida Eficiencia Sistema Fotovoltaico (PESF)',
            'value' => 0.5, // 0.5% anual
            'unit' => '%',
            'description' => 'Pérdida de eficiencia del sistema fotovoltaico por año',
            'effective_date' => now(),
        ]);

        // Costo Mantenimiento Anual (CMA)
        MacroEconomicVariable::create([
            'name' => 'Costo Mantenimiento Anual (CMA)',
            'value' => 2.0, // 2% sobre el CAPEX
            'unit' => '%',
            'description' => 'Costo anual de mantenimiento como porcentaje del CAPEX',
            'effective_date' => now(),
        ]);
    }
}
