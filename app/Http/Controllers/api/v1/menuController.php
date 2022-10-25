<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Category;
class menuController extends Controller
{   
    public function index(Request $request){
        $category = category::all();
        $hoge = (int) $request->contents_limit;
        $menus = menu::find($hoge);
        return response()->json($menus);
    }
}
