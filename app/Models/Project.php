<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property mixed $total
 * @property mixed $sale_value
 */
class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_category_id',
        'zone',
        'kilowatts_to_provide',
        'standard_tool_cost',
        'total',
        'sale_value',
        'status',
    ];

    protected $attributes = [
        'status' => 'Activo'
    ];
    protected $casts = [
        'total' => 'decimal:2',
        'sale_value' => 'decimal:2',
        'kilowatts_to_provide' => 'decimal:2',
        'standard_tool_cost' => 'decimal:2',
    ];
    protected array $dates = [
        'created_at',
        'updated_at',
    ];

    public function projectCategory(): BelongsTo
    {
        return $this->belongsTo(ProjectCategory::class);
    }

    public function additionals(): BelongsToMany
    {
        return $this->belongsToMany(Additional::class, 'additional_project')
            ->withPivot('quantity', 'efficiency', 'total_cost')
            ->withTimestamps();
    }

    public function materials(): BelongsToMany
    {
        return $this->belongsToMany(Material::class, 'material_project')
            ->withPivot('quantity', 'efficiency', 'total_cost')
            ->withTimestamps();
    }

    public function positions(): BelongsToMany
    {
        return $this->belongsToMany(Position::class, 'position_project')
            ->withPivot('quantity', 'required_days', 'efficiency', 'total_cost')
            ->withTimestamps();
    }

    public function tools(): BelongsToMany
    {
        return $this->belongsToMany(Tool::class, 'project_tool')
            ->withPivot('quantity', 'required_days', 'efficiency', 'total_cost')
            ->withTimestamps();
    }

    public function transports(): BelongsToMany
    {
        return $this->belongsToMany(Transport::class, 'project_transport')
            ->withPivot('quantity', 'required_days', 'efficiency', 'total_cost')
            ->withTimestamps();
    }

    public function quotations(): HasMany
    {
        return $this->hasMany(Quotation::class);
    }
}
