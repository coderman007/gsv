<?php

namespace App\Models;

use App\Events\PositionUpdated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    protected $dispatchesEvents = [
        'updated' => PositionUpdated::class,
    ];

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'position_project')
            ->withPivot('quantity', 'required_days', 'efficiency', 'total_cost')
            ->withTimestamps();
    }
}
