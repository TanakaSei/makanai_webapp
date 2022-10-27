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
        //seach_textが入力されているかつoffsetからend_idの間に該当項目がなければ該当なしになる
        //->テーブル全体で一致しているレコードがあっても検索できない
        //
        /*内部連結し
        seach_text空なら，offsetからend_idまでのレコード取得
        または seach_text空でないなら 最大contents_limit個の一致するレコード取得
        */

        $menus = Category::join('menus',function($join)use($offset, $end_id, $seach_text){
            $join->on('menus.category_id', '=','categories.id')
            ->when((!is_null($seach_text) && $seach_text != ''), function($q) use ($seach_text){
                $q->where('menuName', 'like', "%$seach_text%");
            })
            ->when((is_null($seach_text) || $seach_text ==''), function($q) use ($offset, $end_id){
                $q->whereBetween('menus.id', [$offset, $end_id]);        
            });
        })->get();
        /*
        $menus = Category::join('menus',function($join)use($offset, $end_id, $seach_text){
            $join->on('menus.category_id', '=','categories.id')
            ->whereBetween('menus.id', [$offset, $end_id])
            ->where('menuName', 'like', "%$seach_text%");
        })->get();
        */
        return response()->json($menus);
    }
}
