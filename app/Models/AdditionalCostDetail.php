<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalCostDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'additional_cost_id',
        'cost_description',
        'cost_value',
        'subtotal',
    ];

    public function additionalCost()
    {
        return $this->belongsTo(AdditionalCost::class, 'additional_cost_id');
    }
}
