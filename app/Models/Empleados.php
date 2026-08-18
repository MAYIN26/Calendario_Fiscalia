<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\AsignacionCalendario;

class Empleados extends Model
{
    protected $table = 'empleados';

    protected $fillable = [
        'nombre',
        'apellidoPaterno',
        'apellidoMaterno',
        'Correo',
        'curp',
        'foto',
        'activo',
        "alias",
    ];

    public function reservasTelefonos()
    {
        return $this->hasMany(ReservaTelefono::class, 'empleado_id');
    }

    
    public function asignacionesCalendario()
    {
        return $this->hasMany(AsignacionCalendario::class, 'empleado_id');
    }
}