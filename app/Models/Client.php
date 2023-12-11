<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
        'average_energy_consumption',
        'solar_radiation_level',
        'roof_dimensions_length',
        'roof_dimensions_width',
    ];

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function quotations()
    {
        return $this->hasMany(Quotation::class);
    }
}
