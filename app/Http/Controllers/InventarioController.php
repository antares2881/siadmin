<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Inventario;
use App\Empresa;

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

        $validator = Validator::make($request->all(), [
            'producto_id' => 'required|unique:inventarios'
        ]);

        if($validator->fails()){
            return response()->json($validator->messages(), 200);
        }

        $empresa = Empresa::where('user_id', Auth::user()->id)->get();

        $inventario = new Inventario();
        $inventario->empresa_id = $empresa[0]->id;
        $inventario->producto_id = $request->producto_id;
        $inventario->stock = $request->stock;

        $inventario->save();

        return 'ok';

    }
}
