<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalCost extends Model
{
    use HasFactory;

    protected $fillable = [
        'quotation_id',
        'description',
        'amount',
    ];

    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }
}
