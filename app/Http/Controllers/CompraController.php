<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use App\Compra;
use App\Compraproducto;
use App\Inventario;
use App\Empresa;

class CompraController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(Request $request){
        if($request->ajax()){
            $compras = Compra::with(['compraproductos'])->where('user_id', Auth::user()->id)->get();
            return $compras;
        }else{
            return view('compras.index');
        }
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'factura' => 'required|unique:compras'
        ]);

        if($validator->fails()){
            return response()->json($validator->messages(), 200);
        }

        $compra = new Compra();
        $compra->user_id = Auth::user()->id;
        $compra->total = $request->total;
        $compra->factura = $request->factura;

        $compra->save();

        $empresa = Empresa::where('user_id', Auth::user()->id)->get();

        $id = $compra->id;

        for ($i=0; $i < count($request->compras) ; $i++) { 

            $compraproducto = new Compraproducto();
            $compraproducto->compra_id = $id;
            $compraproducto->producto_id = $request->compras[$i]['producto_id'];
            $compraproducto->cantidad = $request->compras[$i]['cantidad'];

            $compraproducto->save();

            $inventario = Inventario::where('producto_id', $request->compras[$i]['producto_id'])->get();

            if(count($inventario) > 0){
                $stock = $inventario[0]->stock + $request->compras[$i]['cantidad'];
                $newinventario = Inventario::find($inventario[0]->id);
                $newinventario->stock = $stock;
                
            }else{
                $newinventario = new Inventario;
                $newinventario->stock = $request->compras[$i]['cantidad'];
            }

            $newinventario->empresa_id = $empresa[0]->id;
            $newinventario->producto_id = $request->compras[$i]['producto_id'];

            $newinventario->save();
        }

        return 'ok';

    }

    public function delete($id){
        
        $compraproducto = Compraproducto::where('compra_id', $id)->get();
        $inventario = Inventario::where('producto_id', $compraproducto[0]->producto_id)->get();

        $stock = $inventario[0]->stock - $compraproducto[0]->cantidad;

        // Actualiza stock de inventario
        $newinventario = Inventario::find($inventario[0]->id);
        $newinventario->stock = $stock;
        $newinventario->save();

        $newcompraproducto = Compraproducto::find($compraproducto[0]->id);

        $newcompraproducto->delete();

        $compra = Compra::find($id);
        $compra->delete();
    }
}
