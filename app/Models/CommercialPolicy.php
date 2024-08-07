<?php

namespace App\Models;

use App\Events\CommercialPolicyUpdated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, string $string1, string $string2)
 */
class CommercialPolicy extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'percentage',
    ];

    protected $dispatchesEvents = [
        'updated' => CommercialPolicyUpdated::class,
    ];
}
