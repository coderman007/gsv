<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaborDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'labor_id',
        'job_position_id',
        'quantity',
        'subtotal',
    ];

    public function labor()
    {
        return $this->belongsTo(Labor::class, 'labor_id');
    }

    public function jobPosition()
    {
        return $this->belongsTo(JobPosition::class, 'job_position_id');
    }
}
