<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdenTrabajoPersonal extends Model
{
    protected $table = "personal";
    protected $fillable = ["personal", "orden_trabajo"];
    public $timestamps = false;
}
