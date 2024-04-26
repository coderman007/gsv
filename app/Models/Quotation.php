<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quotation extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'client_id',
        'quotation_date',
        'validity_period',
        'transformer',
        'total_cost_kilowatt',
        'average_energy_consumption',
        'solar_radiation_level',
        'roof_dimension',
        'internal_commissions',
        'external_commissions',
        'margin',
        'discount',
        'subtotal',
        'total_quotation_amount',
        'status'
    ];

    protected array $dates = [
        'quotation_date',
    ];

    protected string $defaultStatus = 'Activa';

    /**
     * Boot method to initialize event listeners.
     */
    protected static function boot(): void
    {
        parent::boot();

        // Event listener for creating a new quotation
        static::creating(function ($quotation) {
            // Set the default status if status is not provided
            if (empty($quotation->status)) {
                $quotation->status = $quotation->defaultStatus;
            }
        });

        // Event listener for when a quotation is saved
        static::saved(function ($quotation) {
            // Update the status based on the validity period
            if ($quotation->quotation_date->addDays($quotation->validity_period) < now()) {
                $quotation->status = 'Expirada';
                $quotation->save();
            }
        });

        // Event listener for when a quotation is updated
        static::updated(function ($quotation) {
            // Check if the quotation has been accepted
            if ($quotation->isDirty('status') && $quotation->status === 'Aceptada') {
                // Perform any additional actions when the quotation is accepted
                // For example, send notifications, update related records, etc.
            }
        });
    }



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
