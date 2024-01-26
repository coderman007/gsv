<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;


    protected $fillable = [
        'location_id',
        'name',
        'email',
        'phone',
        'tranformer',
        'average_energy_consumption',
        'roof_dimension',
        'status',
        'image'
    ];

    public function quotations()
    {
        return $this->hasMany(Quotation::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
