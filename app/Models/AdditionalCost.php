<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\HigherOrderCollectionProxy;

/**
 * @property HigherOrderCollectionProxy|mixed $name
 */
class AdditionalCost extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'amount',
    ];

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(project::class, 'additional_cost_project')
            ->withPivot('quantity', 'total_cost')
            ->withTimestamps();
    }
}
