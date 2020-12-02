<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use App\Empresa;
use App\Venta;
use App\Productoventa;
use App\Inventario;

class VentaController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(Request $request){
        if($request->ajax()){
            $empresa = Empresa::where('user_id', Auth::user()->id)->get();
            $ventas = Venta::with(['ventaproductos', 'clientes'])->where('empresa_id', $empresa[0]->id)->get();
            return $ventas;
        }else{
            return view('ventas.index');
        }
    }

    public function show($id){
        $venta = Venta::with(['ventaproductos', 'clientes', 'empresas', 'productos'])->find($id);
        return $venta;
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'factura' => 'required|unique:ventas'
        ]);

        if($validator->fails()){
            return response()->json($validator->messages(), 200);
        }

        $empresa = Empresa::where('user_id', Auth::user()->id)->get();

        $venta = new Venta();
        $venta->cliente_id = $request->cliente_id;
        $venta->empresa_id = $empresa[0]->id;
        $venta->total = $request->total;
        $venta->factura = $request->factura;

        $venta->save();

        $id = $venta->id;

        for ($i=0; $i < count($request->ventas) ; $i++) { 

            $ventaproducto = new Productoventa();
            $ventaproducto->venta_id = $id;
            $ventaproducto->producto_id = $request->ventas[$i]['producto_id'];
            $ventaproducto->cantidad = $request->ventas[$i]['cantidad'];

            $ventaproducto->save();

            $inventario = Inventario::where('producto_id', $request->ventas[$i]['producto_id'])->get();
            
            $stock = $inventario[0]->stock - $request->ventas[$i]['cantidad'];
            $newinventario = Inventario::find($inventario[0]->id);
            $newinventario->stock = $stock;

            $newinventario->save();
        }

        return 'ok';

    }
}
