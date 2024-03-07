<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'basic',
        'monthly_work_hours',
        'benefit_factor',
        'real_monthly_cost',
        'real_daily_cost',
    ];

    public function projects()
    {
        return $this->belongsToMany(Project::class)->withPivot('required_days', 'total_cost')->withTimestamps();

    }
}
