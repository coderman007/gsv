<?php

namespace App\Models;

use App\Events\AdditionalUpdated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @method static find(mixed $additionalId)
 * @method static findOrFail($additionalId)
 * @method create(array $additionalData)
 * @property mixed $projects
 */
class Additional extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'unit_price',
    ];

    protected $dispatchesEvents = [
        'updated' => AdditionalUpdated::class,
    ];

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'additional_project')
            ->withPivot('quantity', 'efficiency', 'total_cost')
            ->withTimestamps();
    }
}
