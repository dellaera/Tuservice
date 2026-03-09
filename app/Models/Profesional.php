<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profesional extends Model
{
    use HasFactory;

    protected $fillable = [
        'negocio_id',
        'usuario_id',
        'nombre',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function negocio()
    {
        return $this->belongsTo(Negocio::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }

    public function horarios()
    {
        return $this->hasMany(Horario::class);
    }

    public function turnos()
    {
        return $this->hasMany(Turno::class);
    }
}
