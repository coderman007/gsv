<?php

namespace App\Models;

use App\Events\ToolUpdated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tool extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'unit_price_per_day',
        'image'
    ];

    protected $dispatchesEvents = [
        'updated' => ToolUpdated::class,
    ];
    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class)->withPivot('quantity', 'required_days', 'efficiency', 'total_cost')->withTimestamps();
    }
}
