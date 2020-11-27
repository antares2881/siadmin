<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Empresa;

class EmpresaController extends Controller
{
    public function __contruct(){
        $this->middleware('auth');
    }

    public function index(Request $request){
        if($request->ajax()){
            $empresas = Empresa::all();
            return $empresas;
        }else{
            return view('empresas.index');
        }
    }

    public function show($id){
        $empresa = Empresa::find($id);
        return $empresa;
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'nit' => 'required|unique:empresas',
            'razon_social' => 'required|unique:empresas',
            'telefono' => 'required|unique:empresas',
            'email' => 'required|unique:empresas'
        ]);

        if($validator->fails()){
            return response()->json($validator->messages(), 200);
        }

        $empresa = new Empresa();
        $empresa->user_id = $request->user_id;
        $empresa->nit = $request->nit;
        $empresa->razon_social = $request->razon_social;
        $empresa->servicios = $request->servicios;
        $empresa->direccion = $request->direccion;
        $empresa->telefono = $request->telefono;
        $empresa->email = $request->email;
        $empresa->logo = $request->logo;

        $empresa->save();

        return 'ok';
    }

    public function update(Request $request, $id){

        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'nit' => 'required',
            'razon_social' => 'required',
            'telefono' => 'required',
            'email' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->messages(), 200);
        }

        $empresa = Empresa::find($id);
        
        $empresa->user_id = $request->user_id;
        $empresa->nit = $request->nit;
        $empresa->razon_social = $request->razon_social;
        $empresa->servicios = $request->servicios;
        $empresa->direccion = $request->direccion;
        $empresa->telefono = $request->telefono;
        $empresa->email = $request->email;
        $empresa->logo = $request->logo;

        $empresa->save();

        return 'ok';
    }
}
