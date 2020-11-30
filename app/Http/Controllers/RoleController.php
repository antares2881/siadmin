<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    public function index(){
        $role = DB::table('roles AS r')
        ->select('r.*')
        ->get();
        return $role;
    }
}
