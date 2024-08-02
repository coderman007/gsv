<?php

namespace App\Models;

use App\Events\MaterialUpdated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'material_category_id',
        'reference',
        'rated_power',
        'unit_price',
        'image'
    ];

    protected $dispatchesEvents = [
        'updated' => MaterialUpdated::class,
    ];

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class)
            ->withPivot('quantity', 'efficiency', 'total_cost')
            ->withTimestamps();
    }

    public function materialCategory(): BelongsTo
    {
        return $this->belongsTo(MaterialCategory::class);
    }
}
