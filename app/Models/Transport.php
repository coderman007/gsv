<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\HigherOrderCollectionProxy;

/**
 * @property HigherOrderCollectionProxy|mixed $cost_per_day
 */
class Transport extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_type',
        'gasoline_cost_per_km',
        'cost_per_day',
        'toll_cost',
    ];
    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class)->
            withPivot('quantity', 'required_days', 'total_cost')->
            withTimestamps();
    }
}
