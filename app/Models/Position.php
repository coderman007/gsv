<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'basic', 'benefit_factor'];

    public function projects()
    {
        return $this->belongsToMany(Project::class)->withPivot('required_days')->withTimestamps();

    }
}
