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
        return $this->belongsToMany(Position::class)->withPivot('required_days')->withTimestamps();

    }

}
