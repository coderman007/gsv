<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobPositionCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_name',
        'category_description',
        'category_increment',
    ];

    public function jobPositions()
    {
        return $this->hasMany(JobPosition::class, 'category_id');
    }
}
