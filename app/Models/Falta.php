<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Falta extends Model
{
    protected $table="faltas";
    protected $fillable = ['id', 'personal', 'ot', 'fecha'];
    public $timestamps = false;

    public function ot(){
        return $this->hasOne(OrdenTrabajo::class,'id','ot');
    }

}
