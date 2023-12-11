<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransportDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'transport_id',
        'transport_name',
        'transport_description',
        'transportation_fare',
        'quantity',
        'daily_unit_cost',
        'subtotal',
    ];

    public function transport()
    {
        return $this->belongsTo(Transport::class, 'transport_id');
    }
}
