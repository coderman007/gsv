<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_category_id',
        'project_type_id',
        'name',
        'description',
        'status'
    ];

    public function projectCategory()
    {
        return $this->belongsTo(ProjectCategory::class);
    }

    public function projectType()
    {
        return $this->belongsTo(ProjectType::class);
    }

    public function quotation()
    {
        return $this->hasOne(Quotation::class);
    }
}
