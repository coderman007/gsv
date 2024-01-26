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
        'total_quotation_amount',
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
