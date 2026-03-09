<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    use HasFactory;

    protected $fillable = [
        'negocio_id',
        'nombre',
        'descripcion',
        'precio',
        'duracion_minutos',
        'activo',
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'activo' => 'boolean',
    ];

    public function negocio()
    {
        return $this->belongsTo(Negocio::class);
    }

    public function turnos()
    {
        return $this->hasMany(Turno::class);
    }
}
