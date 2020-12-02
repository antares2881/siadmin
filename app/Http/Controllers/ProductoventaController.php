<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Productoventa;

class ProductoventaController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function show($id){
        $productoventa = Productoventa::with(['productos'])->where('venta_id', $id)->get();
        return $productoventa;
    }
}
