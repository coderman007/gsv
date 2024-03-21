<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'material_category_id',
        'reference',
        'description',
        'unit_price',
    ];

    public function projects()
    {
        return $this->belongsToMany(Project::class)
            ->withPivot('quantity', 'total_cost')
            ->withTimestamps();
    }

    public function materialCategory()
    {
        return $this->belongsTo(MaterialCategory::class);
    }
}
