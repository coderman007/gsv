<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
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

    public function materialDetails()
    {
        return $this->hasMany(MaterialDetail::class, 'material_id');
    }
}
