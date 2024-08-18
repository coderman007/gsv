<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quotation extends Model
{
    use HasFactory;

    // Atributos que pueden ser asignados masivamente
    protected $fillable = [
        'consecutive',
        'project_id',
        'client_id',
        'quotation_date',
        'validity_period',
        'transformer',
        'transformer_power',
        'energy_to_provide',
        'required_area',
        'panels_needed',
        'kilowatt_cost',
        'subtotal',
        'total',
        'status'
    ];

    // Conversión de fechas
    protected $casts = [
        'quotation_date' => 'date',
    ];
    protected static function boot(): void
    {
        parent::boot();

        // Establecer el valor predeterminado al crear una cotización
        static::creating(function ($quotation) {
            if (empty($quotation->status)) {
                $quotation->status = 'Generada';
            }
        });
    }

    // Relaciones con otros modelos
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function additionalCosts(): HasMany
    {
        return $this->hasMany(AdditionalCost::class);
    }

    // Método para obtener el estado basado en la fecha de validez
    public function getStatusAttribute()
    {
        $validUntil = $this->quotation_date->copy()->addDays($this->validity_period);
        $now = Carbon::now();

        if ($now->greaterThan($validUntil)) {
            return 'Expirada';
        } elseif ($now->diffInDays($validUntil) <= 7) {
            return 'Cercana a Expirar';
        } else {
            return 'Válida';
        }
    }

    // Método para obtener el color basado en el estado
    public function getStatusColorAttribute()
    {
        $status = $this->status;

        switch ($status) {
            case 'Expirada':
                return 'text-red-600'; // Color rojo para expiradas
            case 'Cercana a Expirar':
                return 'text-yellow-600'; // Color amarillo para cercanas a expirar
            case 'Válida':
                return 'text-green-600'; // Color verde para válidas
            default:
                return 'text-gray-600'; // Color gris para el estado por defecto
        }
    }
}
