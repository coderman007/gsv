<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transport extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'unit', 'quantity', 'unit_price', 'total_price'];

    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }
}
