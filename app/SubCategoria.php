<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubCategoria extends Model
{
    public $timestamps = false;

    public function categoria(){
        return $this->belongsTo(Categoria::class,"categoria_id");
    }

    public function productos(){
        return $this->hasMany(Productos::class,"id_subcategoria");
    }
}
