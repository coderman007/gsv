<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property mixed $zone
 * @property mixed $power_output
 * @property mixed $required_area
 * @property mixed $total_labor_cost
 * @property mixed $total_material_cost
 * @property mixed $hand_tool_cost
 * @property mixed $total_tool_cost
 * @property mixed $total_transport_cost
 * @property mixed $total_additional_cost
 * @property mixed $sale_value
 * @property mixed $additionals
 */
class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_category_id',
        'zone',
        'power_output',
        'required_area',
        'hand_tool_cost',
        'raw_value',
        'sale_value',
        'status',
        'total_labor_cost',
        'total_tool_cost',
        'total_material_cost',
        'total_transport_cost',
        'total_additional_cost',
    ];

    protected $attributes = [
        'status' => 'Activo',
    ];

    protected $casts = [
        'total' => 'decimal:2',
        'sale_value' => 'decimal:2',
        'power_output' => 'decimal:2',
        'required_area' => 'decimal:2',
        'hand_tool_cost' => 'decimal:2',
        'total_labor_cost' => 'decimal:2',
        'total_tool_cost' => 'decimal:2',
        'total_material_cost' => 'decimal:2',
        'total_transport_cost' => 'decimal:2',
        'total_additional_cost' => 'decimal:2'
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

    public function updateTotalCost(): void
    {
        // Calcular el costo total de cada recurso
        $totalLaborCost = $this->positions->sum(function ($position) {
            $pivotData = $position->pivot;
            return $position->real_daily_cost * $pivotData->quantity * $pivotData->required_days * $pivotData->efficiency;
        });

        $totalMaterialCost = $this->materials->sum(function ($material) {
            $pivotData = $material->pivot;
            return $material->unit_price * $pivotData->quantity * $pivotData->efficiency;
        });

        $totalToolCost = $this->tools->sum(function ($tool) {
            $pivotData = $tool->pivot;
            return $tool->unit_price_per_day * $pivotData->quantity * $pivotData->required_days * $pivotData->efficiency;
        });

        $totalTransportCost = $this->transports->sum(function ($transport) {
            $pivotData = $transport->pivot;
            return $transport->cost_per_day * $pivotData->quantity * $pivotData->required_days * $pivotData->efficiency;
        });

        $totalAdditionalCost = $this->additionals->sum(function ($additional) {
            $pivotData = $additional->pivot;
            return $additional->unit_price * $pivotData->quantity * $pivotData->efficiency;
        });

        // Calcular el costo de las herramientas de mano (5% del total de la mano de obra)
        $handToolCost = $totalLaborCost * 0.05;

        // Calcular el valor bruto incluyendo el costo de la herramienta de mano
        $rawValue = $totalLaborCost + $totalMaterialCost + $totalToolCost + $totalTransportCost + $totalAdditionalCost + $handToolCost;

        // Obtener valores para las políticas comerciales
        $internalCommissions = CommercialPolicy::where('name', 'like', 'Comisiones Internas')->first()?->percentage ?? 0;
        $externalCommissions = CommercialPolicy::where('name', 'like', 'Comisiones Externas')->first()?->percentage ?? 0;
        $margin = CommercialPolicy::where('name', 'like', 'Margen')->first()?->percentage ?? 0;
        $discount = CommercialPolicy::where('name', 'like', 'Descuento')->first()?->percentage ?? 0;

        // Calcular las políticas comerciales
        $internalCommissionsValue = $internalCommissions / 100;
        $externalCommissionsValue = $externalCommissions / 100;
        $marginValue = $margin / 100;
        $discountValue = $discount / 100;

        // Calcular el precio de venta del proyecto
        $denominator = (1 - $marginValue - $internalCommissionsValue - $externalCommissionsValue) * (1 - $discountValue);

        if ($denominator > 0) {
            $saleValue = $rawValue / $denominator;
        } else {
            $saleValue = 0;
        }
        // Actualizar el proyecto con los nuevos valores
        $this->update([
            'hand_tool_cost' => $handToolCost,
            'total_labor_cost' => $totalLaborCost,
            'total_material_cost' => $totalMaterialCost,
            'total_tool_cost' => $totalToolCost,
            'total_transport_cost' => $totalTransportCost,
            'total_additional_cost' => $totalAdditionalCost,
            'raw_value' => $rawValue,
            'sale_value' => $saleValue,
        ]);
    }
}
