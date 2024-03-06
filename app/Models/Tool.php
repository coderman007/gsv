<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tool extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'unit', 'percentage', 'quantity', 'unit_price', 'surcharge'];

    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }
}
