<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AsignacionCalendario extends Model
{
    protected $table = 'asignaciones_calendario';

    protected $fillable = [
        'empleado_id',
        'empleado_original_id',
        'fecha',
        'nombre_dia',
        'tipo',
        'modificado_manual'
    ];

    protected $casts = [
        'fecha' => 'date',
        'empleado_id' => 'int',
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleados::class, 'empleado_id');
    }


    public function empleadoOriginal()
    {
        return $this->belongsTo(Empleados::class, 'empleado_original_id');
    }
}
