<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReservaTelefono extends Model
{
    protected $table = 'reservas_telefonos';

    protected $fillable = [
        'empleado_id',
        'fecha',
        'posicion',
    ];

    public function empleado()
    {
        return $this->belongsTocd(Empleados::class, 'empleado_id');
    }
}