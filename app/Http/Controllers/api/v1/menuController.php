<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
class menuController extends Controller
{   
    public function index(){
        $menus = menu::all();
        return response()->json($menus);
    }
}


