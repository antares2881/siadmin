<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    public function compraproductos(){
        return $this->hasMany(Compraproducto::class);
    }

    public function productos(){
        return $this->hasOneThrough(Producto::class, Compraproducto::class, 'producto_id', 'id', 'id', 'producto_id');
    }

}
