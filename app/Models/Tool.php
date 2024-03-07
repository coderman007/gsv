<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tool extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'unit_price_per_day',
    ];
    public function projects()
    {
        return $this->belongsToMany(Project::class)->
            withPivot('quantity', 'required_days', 'total_cost')->
            withTimestamps();
    }
}
