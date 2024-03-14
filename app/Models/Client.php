<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'city_id',
        'type',
        'name',
        'document',
        'email',
        'address',
        'phone',
        'status',
        'image',
    ];

    public function quotations()
    {
        return $this->hasMany(Quotation::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
