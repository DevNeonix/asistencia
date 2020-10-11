<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdenTrabajoPersonal extends Model
{
    protected $table = "orden_trabajo_personal";
    protected $fillable = ["personal", "orden_trabajo"];
    public $timestamps = false;
}
