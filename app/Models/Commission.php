<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'sales_value',
        'commission_percentage',
        'commission_amount',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
