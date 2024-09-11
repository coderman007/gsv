<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MacroEconomicVariable extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',  // Nombre de la variable (e.g., IPC, IR, IACE, PESF, CMA)
        'value', // Valor actual de la variable
        'unit',  // Unidad de medida (e.g., %, COP/kWh)
        'description', // Descripción o detalles adicionales sobre la variable
        'effective_date', // Fecha desde la cual esta variable es efectiva
    ];

    protected $casts = [
        'value' => 'decimal:1',  // Valor decimal con cuatro decimales de precisión
        'effective_date' => 'date',  // Fecha de efectividad
    ];

    /**
     * Scope para obtener el valor más reciente de una variable dada por su nombre.
     */
    public function scopeLatestValue($query, $name)
    {
        return $query->where('name', $name)->orderBy('effective_date', 'desc')->first();
    }
}
