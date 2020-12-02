<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    public function clientes(){
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function empresas(){
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }

    public function ventaproductos(){
        return $this->hasMany(Productoventa::class);
    }

    public function productos(){
        return $this->hasManyThrough(Producto::class, Productoventa::class, 'venta_id', 'id', 'id', 'producto_id');
    }
}
