<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Producto;

class ProductoController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(Request $request){
        if($request->ajax()){

            $productos = Producto::with(['categorias'])->get();
            return $productos;

        }else{
            return view('productos.index');
        }
    }

    public function show($id){
        $producto = Producto::find($id);
        return $producto;
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|unique:productos'
        ]);

        if($validator->fails()){
            return response()->json($validator->messages(), 200);
        }

        $producto = new Producto();
        $producto->categoria_id = $request->categoria_id;
        $producto->nombre = $request->nombre;
        $producto->marca = $request->marca;
        $producto->precio = $request->precio;

        $producto->save();

        return 'ok';

    }

    public function update(Request $request, $id){
       
        $producto = Producto::find($id);

        $producto->categoria_id = $request->categoria_id;
        $producto->nombre = $request->nombre;
        $producto->marca = $request->marca;
        $producto->precio = $request->precio;

        $producto->save();

        return 'ok';

    }

    public function delete($id){
        $producto = Producto::find($id);
        $producto->delete();        
    }
}
