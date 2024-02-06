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
        'materials_price',
        'tools_price',
        'labor_price',
        'transport_price',
        'commission',
        'total_quotation_amount',
    ];

    protected $dates = [
        'quotation_date',  // Indica que 'quotation_date' debe ser tratado como una instancia de Carbon.
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
