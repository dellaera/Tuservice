<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turno extends Model
{
    use HasFactory;

    protected $fillable = [
        'negocio_id',
        'profesional_id',
        'cliente_id',
        'servicio_id',
        'fecha',
        'hora_inicio',
        'hora_fin',
        'estado',
        'precio',
        'notas',
        'recordatorio_enviado_at',
    ];

    protected $casts = [
        'fecha' => 'date',
        'precio' => 'decimal:2',
        'recordatorio_enviado_at' => 'datetime',
    ];

    public function negocio()
    {
        return $this->belongsTo(Negocio::class);
    }

    public function profesional()
    {
        return $this->belongsTo(Profesional::class);
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function servicio()
    {
        return $this->belongsTo(Servicio::class);
    }
}
