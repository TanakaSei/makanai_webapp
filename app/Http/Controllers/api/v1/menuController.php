<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Category;
class menuController extends Controller
{   
    public function index(Request $request){
        $contents_limit = (int) $request->contents_limit;
        $menus = menu::find($contents_limit);
        $category = category::find($menus->categoryNumber);
        return response()->json($menus);
    }
}
