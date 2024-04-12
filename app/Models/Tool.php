<?php

namespace App\Models;

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
    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class)->withPivot('quantity', 'required_days', 'total_cost')->withTimestamps();
    }
}
