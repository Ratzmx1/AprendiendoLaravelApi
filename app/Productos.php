<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Productos extends Model
{
    public function subcategoria(){
        return $this->belongsTo(SubCategoria::class,"id_subcategoria");
    }

    public function salidas(){
        return $this->hasMany(salida::class,"id_producto");
    }

    public function entradas(){
        return $this->hasMany(entrada::class,"id_producto");
    }
}

