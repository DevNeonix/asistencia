<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Marcacion extends Model
{
    protected $table = "marcacion";
    protected $fillable = ['id', 'personal', 'orden_trabajo', 'fecha', 'usuario_registra', "fechaymd", "minutos_extra","viatico"];
    public $timestamps = false;

    function personal_complete()
    {
        return $this->hasOne(Personal::class, 'id', 'personal')->orderBy('apellidos');
    }

    function ot(){
	return $this->hasOne(OrdenTrabajo::class,'id','orden_trabajo');
    }

}
