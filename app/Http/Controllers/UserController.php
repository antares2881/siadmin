<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use App\User;

class UserController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(Request $request){
        if($request->ajax()){
            $users = DB::table('users AS u')
                ->join('roles AS r', 'u.role_id', 'r.id')
                ->select('u.*', 'r.role')
                ->get();
            return $users;
        }else{
            return view('users.index');
        }
    }

    public function show($id){
        $usuario = User::find($id);
        return $usuario;
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'role_id' => 'required',
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|min:8'
        ]);

        if($validator->fails()){
            return response()->json($validator->messages(), 200);
        }

        $usuario = new User();
        $usuario->role_id = $request->role_id;
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->password = Hash::make($request->password);

        $usuario->save();

        return 'ok';
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'role_id' => 'required',
            'name' => 'required',
            'email' => 'required|unique:users,email,'.$request->id
        ]);

        if($validator->fails()){
            return response()->json($validator->messages(), 200);
        }

        $usuario = User::find($id);
        $usuario->role_id = $request->role_id;
        $usuario->name = $request->name;
        $usuario->email = $request->email;

        $usuario->save();

        return 'ok';
    }
}
