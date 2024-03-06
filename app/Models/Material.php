<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'unit', 'quantity', 'unit_price', 'total_price', 'surcharge'];

    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }
}
