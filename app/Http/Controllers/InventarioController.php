<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Inventario;

class InventarioController extends Controller
{
    public function index(Request $request){

        if($request->ajax()){

            $inventario = Inventario::with(['productos'])->get();
            return $inventario;

        }else{
            return view('inventario.index');
        }

    }

    public function store(Request $request){

        $inventario = new Inventario();
        $inventario->producto_id = $request->producto_id;
        $inventario->stock = $request->stock;

        $inventario->save();

        return 'ok';

    }
}
