<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Category;
class menuController extends Controller
{   
    public function index(Request $request){
        //各ページの取得件数の上限を設定
        if(isset($request->contents_limit)){
            $contents_limit = (int) $request->contents_limit;
        }
        else{
            $contents_limit = 10; 
        }
        //ページごとに必要なレコードを取得したいので開始idを受け取る
        if(isset($request->offset)){
            $offset = (int) $request->offset;
        }
        else{
            $offset = 1;
        }
        //文字検索
        if(isset($request->seach_text)){
            $seach_text = (string)$request->seach_text;
        }
        else{
            $seach_text = '';
        }
        $end_id = $offset+$contents_limit;
        $menus = Category::join('menus',function($join)use($offset, $end_id, $seach_text){
            $join->on('menus.category_id', '=','categories.id')
            ->whereBetween('menus.id', [$offset, $end_id])
            ->where('menuName', 'like', "%$seach_text%");
        })->get();
        return response()->json($menus);
    }
}
