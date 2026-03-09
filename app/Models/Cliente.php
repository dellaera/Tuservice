<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'negocio_id',
        'nombre',
        'telefono',
        'email',
        'notas',
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
