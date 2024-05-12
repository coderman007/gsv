<?php

namespace App\Models;

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

    // Mapeo de traducciones para los nombres de las políticas comerciales
    protected $policyTranslations = [
        'internal_commissions' => 'Comisiones Internas',
        'external_commissions' => 'Comisiones Externas',
        'margin' => 'Margen',
        'discount' => 'Descuento',
    ];

    // Accesor para obtener el nombre traducido
    public function getNameAttribute($value)
    {
        return $this->policyTranslations[$value] ?? $value;
    }
}
