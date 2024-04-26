<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property mixed $zone
 */
class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_category_id',
        'name',
        'zone',
        'kilowatts_to_provide',
        'internal_commissions',
        'external_commissions',
        'margin',
        'discount',
        'total',
        'status',
    ];

    protected $attributes = [
        'status' => 'Activo'
    ];

    public function projectCategory(): BelongsTo
    {
        return $this->belongsTo(ProjectCategory::class);
    }

    public function positions(): BelongsToMany
    {
        return $this->belongsToMany(Position::class)->withPivot('required_days', 'total_cost')->withTimestamps();
    }

    public function materials(): BelongsToMany
    {
        return $this->belongsToMany(Material::class)->withPivot('quantity', 'total_cost')->withTimestamps();
    }

    public function tools(): BelongsToMany
    {
        return $this->belongsToMany(Tool::class)->withPivot('required_days', 'quantity', 'total_cost')->withTimestamps();
    }

    public function transports(): BelongsToMany
    {
        return $this->belongsToMany(Transport::class)->withPivot('required_days', 'quantity', 'total_cost')->withTimestamps();
    }

    public function additionalCosts(): BelongsToMany
    {
        return $this->belongsToMany(AdditionalCost::class, 'additional_cost_project')
            ->withPivot('quantity', 'total_cost')
            ->withTimestamps();
    }

    public function totalAdditionalCost()
    {
        // Retornar una relación que calcule el costo total de los costos adicionales asociados
        return $this->additionalCosts()->sum('total_cost');
    }


    public function totalLaborCost()
    {
        // Retornar una relación que calcule el costo total de las posiciones asociadas
        return $this->positions()->sum('total_cost');
    }

    public function totalMaterialCost()
    {
        // Retornar una relación que calcule el costo total de los materiales asociados
        return $this->materials()->sum('total_cost');
    }

    public function totalToolCost()
    {
        // Retornar una relación que calcule el costo total de las herramientas asociadas
        return $this->tools()->sum('total_cost');
    }

    public function totalTransportCost()
    {
        // Retornar una relación que calcule el costo total de los transportes asociados
        return $this->transports()->sum('total_cost');
    }

    public function quotations(): HasMany
    {
        return $this->hasMany(Quotation::class);
    }
}
