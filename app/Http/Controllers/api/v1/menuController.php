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
            $seach_text = null;
        }
        $end_id = $offset+$contents_limit-1;
        $menus = Category::join('menus',function($join)use($offset, $end_id, $seach_text, $contents_limit){
            $join->on('menus.category_id', '=','categories.id')
            ->when((!is_null($seach_text) && $seach_text != ''), function($q) use ($seach_text, $contents_limit){
                $q->where('menuName', 'like', "%$seach_text%")->orWhere('categoryName', 'like', "%$seach_text%");
            })
            ->when((is_null($seach_text) || $seach_text ==''), function($q) use ($offset, $end_id){
                $q->whereBetween('menus.id', [$offset, $end_id]);        
            });
        })->orderBy('menus.id', 'asc')->get()->take($contents_limit);


        $total_num = Menu::max('id');


        return response()->json([
            'data' => $menus,
            //'next_page_id' => $offset+$total_num,
            'total_num' => $total_num,
        ]);
    }

    public function lottery(Request $request){
        if(isset($request->select_num)){
            $select_num = $request->select_num;
        }
        else{
            $select_num = 3;
        }
        $ignore_category = $request->ignore_category;

        /*
        select_num個のtarget_categoryに合致するレコードをランダムに取得
        */
        $menus = Category::join('menus',function($join)use($ignore_category){
            $join->on('menus.category_id', '=','categories.id')
            ->when((!is_null($ignore_category)), function($q) use ($ignore_category){
                $q->whereNotIn('category_id', $ignore_category);
            });
        })->inRandomOrder()->get()->take($select_num);

        return response()-> json($menus);
    }
}
