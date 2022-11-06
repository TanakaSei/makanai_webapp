<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Category;
class menuController extends Controller
{   
    public function index(Request $request){
        /*
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
            $offset = 0;
        }
        //文字検索
        if(isset($request->search_text)){
            $search_text = (string)$request->search_text;
        }
        else{
            $search_text = null;
        }
        $end_id = $offset+$contents_limit;
        $tmp = Menu::orderBy('id', 'desc')->first()->toArray();
        $total_num =  $tmp['id'];
        //$total_num =  null;
        $hoge = -1;
        $menus = Category::join('menus',function($join)use($offset, $end_id, $search_text, $contents_limit){
            $join->on('menus.category_id', '=','categories.id')
            ->when((!is_null($search_text) && $search_text != ''), function($q) use ($search_text, $contents_limit){
                $q->where('menuName', 'like', "%$search_text%");
            }, function($q) use ($offset, $end_id){
                $q->whereBetween('menus.id', [$offset, $end_id]);        
            });
        })->orderBy('menus.id', 'asc')->get()->take($contents_limit);
        
        
        //文字検索の該当件数 > １ページあたりの表示数の時総数が正しくない
        if(!is_null($search_text) && $search_text != ''){
            //$total_num = max(array_column($menus->toArray(), 'id'));
            //$total_num = $menus->count();
        }
        return response()->json([
            'data' => $menus,
            //'next_page_id' => $offset+$total_num,
            'total_num' => $total_num,
            'search_txt'=> $search_text,
        ]);
        */
        $menus = Category::join('menus','menus.category_id', '=','categories.id')->orderBy('menus.id','asc')->get();
        //$huga = Category::with('menus')->get();
        //$huga = Menu::with('Category')->get();
        $total_num = $menus->count();
        $hoge = -1;
        $search_text = $request->search_text;
        $contents_limit = $request->contents_limit;
        $offset = $request->offset;

        if(!is_null($search_text)){
            $hoge = 0;
            $menus = $menus->filter(function($record) use ($search_text){
                return strpos($record['menuName'],$search_text) !== false;
            });
            $total_num = $menus->count();
            
        }
        $total_num = $menus->count();

        if(!is_null($contents_limit) && !is_null($offset)){
            $hoge =1;
            $menus = $menus->slice($offset, $contents_limit);
        }

        //vue側のresponse.data.dataが2ページ目以降添え字（？）が1ページ目の続きからになるため
        //arrayでなくobjectになるので以下暫定処理
        $tmp_num = $menus->count();
        $response_menu=[];
        for($i=$offset;$i<$offset+$tmp_num;$i++){
            $response_menu[] = $menus[$i];
        }
            
        return response()->json([
            'data'=> $response_menu,
            'total_num' => $total_num,
            'offset' => $offset,
            'search_text' =>$search_text,
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
