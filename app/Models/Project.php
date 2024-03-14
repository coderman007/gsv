<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_category_id',
        'name',
        'description',
        'kilowatts_to_provide',
        'zone',
        'status',
    ];

    public function projectCategory()
    {
        return $this->belongsTo(ProjectCategory::class);
    }

    public function positions()
    {
        return $this->belongsToMany(Position::class)->withPivot('required_days', 'total_cost')->withTimestamps();
    }

    public function materials()
    {
        return $this->belongsToMany(Material::class)->withPivot('quantity', 'total_cost')->withTimestamps();
    }

    public function tools()
    {
        return $this->belongsToMany(Tool::class)->withPivot('required_days', 'quantity', 'total_cost')->withTimestamps();
    }

    public function transports()
    {
        return $this->belongsToMany(Transport::class)->withPivot('required_days', 'quantity', 'total_cost')->withTimestamps();
    }

    public function totalLaborCost()
    {
        // Implementa la lógica para sumar los costos totales de las posiciones asociadas
        return $this->positions->sum('pivot.total_cost');
    }


    // Dentro del modelo Project
    public function totalMaterialCost()
    {
        // Implementa la lógica para sumar los costos totales de los materiales asociados
        return $this->materials->sum('pivot.total_cost');
    }

    public function totalToolCost()
    {
        // Implementa la lógica para sumar los costos totales de las herramientas asociadas
        return $this->tools->sum('pivot.total_cost');
    }

    public function totalTransportCost()
    {
        // Implementa la lógica para sumar los costos totales de los transportes asociados
        return $this->transports->sum('pivot.total_cost');
    }

    public function quotations()
    {
        return $this->hasMany(Quotation::class);
    }
}
