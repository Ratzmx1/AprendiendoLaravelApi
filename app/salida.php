<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class salida extends Model
{
    public function producto(){
        return $this->belongsTo(Productos::class);
    }
}
