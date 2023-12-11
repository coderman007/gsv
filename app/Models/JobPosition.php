<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobPosition extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'job_position_name',
        'daily_salary',
        'work_performance',
    ];

    public function category()
    {
        return $this->belongsTo(JobPositionCategory::class, 'category_id');
    }

    public function laborDetails()
    {
        return $this->hasMany(LaborDetail::class, 'job_position_id');
    }
}
