<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'client_id',
        'quotation_date',
        'validity_period',
        'transformer',
        'average_energy_consumption',
        'solar_radiation_level',
        'roof_dimension',
        'internal_commissions',
        'external_commissions',
        'margin',
        'discount',
        'subtotal',
        // 'iva', Se va. No aplica
        // Costo actual del Kilovatio
        'total_quotation_amount',
    ];

    protected $dates = [
        'quotation_date', // Indica que 'quotation_date' debe ser tratado como una instancia de Carbon.
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function additionalCosts()
    {
        return $this->hasMany(AdditionalCost::class);
    }
}
