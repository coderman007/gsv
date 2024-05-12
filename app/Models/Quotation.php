<?php

namespace App\Models;

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
        'energy_to_provide',
        'roof_dimension',
        'kilowatt_cost',
        'subtotal',
        'total',
        'status'
    ];

    // Conversión de fechas
    protected array $dates = [
        'quotation_date',
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
}
