<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdenTrabajo extends Model
{
    protected $table="orden_trabajo";
    protected $fillable = ['id', 'nro_orden', 'producto_fabricar', 'cliente','estado'];
    public $timestamps = false;
}
