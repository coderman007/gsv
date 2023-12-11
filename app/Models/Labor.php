<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Labor extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'work_days_quantity',
        'daily_total_cost',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function laborDetails()
    {
        return $this->hasMany(LaborDetail::class, 'labor_id');
    }
}
