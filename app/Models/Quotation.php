<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Quotation extends Model
{
    use HasFactory;

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

    protected $casts = [
        'quotation_date' => 'date',
    ];

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

    public function cashFlow(): HasOne
    {
        return $this->hasOne(CashFlow::class);
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($quotation) {
            if (empty($quotation->status)) {
                $quotation->status = 'Generada';
            }
        });
    }

    public function getStatusAttribute()
    {
        // Verificar si la clave 'status' existe en el array antes de acceder a ella
        if (!array_key_exists('status', $this->attributes)) {
            return 'Generada'; // Valor por defecto
        }

        $validUntil = $this->quotation_date->copy()->addDays($this->validity_period);
        $now = Carbon::now();

        if ($this->attributes['status'] === 'Ganada') {
            return 'Ganada';
        }

        if ($now->greaterThan($validUntil)) {
            return 'Perdida';
        }

        return $this->attributes['status'];
    }


    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'Ganada' => 'text-green-600',
            'Perdida' => 'text-red-600',
            default => 'text-blue-600',
        };
    }

    public function markAsWon(): void
    {
        $this->status = 'Ganada';
        $this->save();
    }

    public function markAsLost(): void
    {
        $this->status = 'Perdida';
        $this->save();
    }

    public function getFormattedTotalAttribute(): string
    {
        return number_format($this->total, 2, '.', ',');
    }
}
