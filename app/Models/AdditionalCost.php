<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalCost extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'daily_total_cost',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function additionalCostDetails()
    {
        return $this->hasMany(AdditionalCostDetail::class, 'additional_cost_id');
    }
}
