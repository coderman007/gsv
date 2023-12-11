<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transport extends Model
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

    public function transportDetails()
    {
        return $this->hasMany(TransportDetail::class, 'transport_id');
    }
}
