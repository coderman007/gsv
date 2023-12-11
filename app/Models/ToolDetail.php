<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToolDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'tool_id',
        'tool_name',
        'tool_description',
        'quantity',
        'daily_unit_cost',
        'subtotal',
    ];

    public function tool()
    {
        return $this->belongsTo(Tool::class, 'tool_id');
    }
}
