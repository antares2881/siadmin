<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Proveedore;

class ProveedoreController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(Request $request){
        if($request->ajax()){
            $proveedores = Proveedore::all();
            return $proveedores;
        }else{
            return view('proveedores.index');
        }
    }

    public function show($id){
        $proveedor = Proveedore::find($id);
        return $proveedor;
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'id' => 'required|unique:proveedores',
            'nombres' => 'required',
            'apellidos' => 'required',
            'direccion' => 'required',
            'telefono' => 'required',
            'email' => 'required|unique:proveedores',
        ]);

        if($validator->fails()){
            return response()->json($validator->messages(), 200);
        }

        $proveedor = new Proveedore();
        $proveedor->id = $request->id;
        $proveedor->nombres = $request->nombres;
        $proveedor->apellidos = $request->apellidos;
        $proveedor->direccion = $request->direccion;
        $proveedor->telefono = $request->telefono;
        $proveedor->email = $request->email;

        $proveedor->save();

        return 'ok';
    }

    public function update(Request $request, $id){

        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'nombres' => 'required',
            'apellidos' => 'required',
            'direccion' => 'required',
            'telefono' => 'required',
            'email' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->messages(), 200);
        }

        $proveedor = Proveedore::find($id);
        
        $proveedor->nombres = $request->nombres;
        $proveedor->apellidos = $request->apellidos;
        $proveedor->direccion = $request->direccion;
        $proveedor->telefono = $request->telefono;
        $proveedor->email = $request->email;

        $proveedor->save();

        return 'ok';
    }
}
