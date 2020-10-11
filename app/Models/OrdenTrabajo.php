<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdenTrabajo extends Model
{
    protected $table = "orden_trabajo";
    protected $fillable = ['id', 'nro_orden', 'producto_fabricar', 'cliente', 'estado', 'centro_costo_id', "ubicacion", "viatico"];
    public $timestamps = false;

    public function personal()
    {
        return $this->hasMany(OrdenTrabajoPersonal::class, 'orden_trabajo', 'id');
    }

}
