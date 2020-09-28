<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RolEmpleado extends Model
{
    protected $table="rol_empleado";
    protected $fillable = ['id', 'detalle'];
    public $timestamps = false;
}
