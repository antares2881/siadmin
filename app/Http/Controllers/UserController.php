<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(Request $request){
        if($request->ajax()){
            $users = User::all();
            return $users;
        }else{
            return view('users.index');
        }
    }
}
