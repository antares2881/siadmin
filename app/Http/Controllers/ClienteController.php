<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Cliente;

class ClienteController extends Controller
{
    public function __construc(){
        $this->middleware('auth');
    }

    public function index(Request $request){

        if($request->ajax()){
            $clientes = Cliente::all();
            return $clientes;
        }else{
            return view('clientes.index');
        }
    }

    public function show($id){
        $cliente = Cliente::find($id);
        return $cliente;
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'id' => 'required|unique:clientes',
            'email' => 'required|unique:clientes'
        ]);

        if($validator->fails()){
            return response()->json($validator->messages(), 200);
        }

        $cliente = new Cliente();
        $cliente->id = $request->id;
        $cliente->nombres = $request->nombres;
        $cliente->apellidos = $request->apellidos;
        $cliente->direccion = $request->direccion;
        $cliente->telefono = $request->telefono;
        $cliente->email = $request->email;

        $cliente->save();

        return 'ok';

    }

    public function update(Request $request, $id){        

        $cliente = Cliente::find($id);
        $cliente->nombres = $request->nombres;
        $cliente->apellidos = $request->apellidos;
        $cliente->direccion = $request->direccion;
        $cliente->telefono = $request->telefono;
        $cliente->email = $request->email;

        $cliente->save();

        return 'ok';

    }
}
