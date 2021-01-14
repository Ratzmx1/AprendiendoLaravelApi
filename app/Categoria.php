<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    public $timestamps = false;

    public function subcategorias(){
        return $this->hasMany(SubCategoria::class);
    }

}
