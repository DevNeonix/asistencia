<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    protected $table = "personal";
    protected $fillable = ["id", "nombres", "apellidos", "doc_ide", "tipo", "remuneracion", "costo_hora", "costo_hora_25", "costo_hora_35", "costo_hora_100", "asignacion_familiar"];
    public $timestamps = false;
}
