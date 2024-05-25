<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @method static find(mixed $additionalId)
 * @method static findOrFail($additionalId)
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

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(project::class, 'additional_project')
            ->withPivot('quantity', 'efficiency', 'total_cost')
            ->withTimestamps();
    }
}
