<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'slug',
        'descripcion',
        'precio_mensual',
        'moneda',
        'max_profesionales',
        'max_turnos_mensuales',
        'incluye_recordatorios',
        'incluye_estadisticas',
        'incluye_reportes',
        'activo',
    ];

    protected $casts = [
        'precio_mensual' => 'decimal:2',
        'incluye_recordatorios' => 'boolean',
        'incluye_estadisticas' => 'boolean',
        'incluye_reportes' => 'boolean',
        'activo' => 'boolean',
    ];

    public function suscripciones()
    {
        return $this->hasMany(Suscripcion::class);
    }
}
