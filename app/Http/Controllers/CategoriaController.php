<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Categoria;

class CategoriaController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(Request $request){
        if($request->ajax()){
            $categorias = Categoria::all();
            return $categorias;
        }else{
            return view('categorias.index');
        }
    }

    public function show($id){
        $categoria = Categoria::find($id);
        return $categoria;
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'categoria' => 'required|unique:categorias'
        ]);

        if($validator->fails()){
            return response()->json($validator->messages(), 200);
        }

        $categoria = new Categoria();
        $categoria->categoria = $request->categoria;

        $categoria->save();

        return 'ok';
    }

    public function update(Request $request, $id){

        $validator = Validator::make($request->all(), [
            'categoria' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->messages(), 200);
        }

        $categoria = Categoria::find($id);
        $categoria->categoria = $request->categoria;

        $categoria->save();

        return 'ok';
    }
}
