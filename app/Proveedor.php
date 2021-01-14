<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    public function usuarios(){
        return $this->hasMany(User::class);
    }
}
