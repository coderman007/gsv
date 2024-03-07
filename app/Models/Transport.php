<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transport extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_type',
        'annual_mileage',
        'average_speed',
        'commercial_value',
        'depreciation_rate',
        'annual_maintenance_cost',
        'cost_per_km_conventional',
        'cost_per_km_fuel',
        'salary_per_month',
        'salary_per_hour',
    ];
    public function projects()
    {
        return $this->belongsToMany(Project::class)->
            withPivot('quantity', 'required_days', 'total_cost')->
            withTimestamps();
    }
}
