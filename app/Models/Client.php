<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'location_id',
        'type',
        'name',
        'email',
        'phone',
        'status',
        'image',
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
