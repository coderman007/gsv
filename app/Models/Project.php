<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'project_name',
        'project_type',
        'description',
        'required_kilowatts',
        'start_date',
        'expected_end_date',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function quotations()
    {
        return $this->hasMany(Quotation::class);
    }
}
