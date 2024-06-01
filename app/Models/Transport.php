<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\HigherOrderCollectionProxy;

/**
 * @property HigherOrderCollectionProxy|mixed $cost_per_day
 * @property HigherOrderCollectionProxy|mixed $capacity
 * @property HigherOrderCollectionProxy|mixed $fuel_type
 */
class Transport extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_type',
        'cost_per_day',
        'capacity',
        'fuel_type'
    ];
    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class)->
            withPivot('quantity', 'required_days', 'efficiency', 'total_cost')->
            withTimestamps();
    }
}
