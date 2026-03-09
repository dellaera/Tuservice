<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Negocio extends Model
{
    use HasFactory;

    protected $fillable = [
        'usuario_id',
        'rubro_id',
        'nombre',
        'descripcion',
        'direccion',
        'ciudad',
        'telefono',
        'email',
        'slug',
        'sitio_web',
        'timezone',
        'trial_ends_at',
    ];

    protected $casts = [
        'trial_ends_at' => 'datetime',
    ];

    public function dueno()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function rubro()
    {
        return $this->belongsTo(Rubro::class);
    }

    public function profesionales()
    {
        return $this->hasMany(Profesional::class);
    }

    public function servicios()
    {
        return $this->hasMany(Servicio::class);
    }

    public function clientes()
    {
        return $this->hasMany(Cliente::class);
    }

    public function turnos()
    {
        return $this->hasMany(Turno::class);
    }

    public function suscripciones()
    {
        return $this->hasMany(Suscripcion::class);
    }
}
