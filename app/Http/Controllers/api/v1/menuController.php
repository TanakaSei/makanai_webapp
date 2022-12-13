<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Category;

//Log出力
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;



class menuController extends Controller
{   
    public function index(Request $request){
        $menus = Category::join('menus','menus.category_id', '=','categories.id')->orderBy('menus.id','asc')->get();
        $total_num = $menus->count();
        $search_text = $request->search_text;
        $contents_limit = $request->contents_limit;
        $offset = $request->offset;

        if(!is_null($search_text)){
            $hoge = 0;
            $menus = $menus->filter(function($record) use ($search_text){
                return strpos($record['menu_name'],$search_text) !== false;
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

        if($tmp_num >0){

            //Log::debug("tmp_num=".$tmp_num);
            //Log::debug("menus=".$menus);
            //$menusには$menus[id-1]の位置に該当データが保持されている状態
            //つまり，返すデータのインデックスは0から始まるとは限らず，番号が飛ぶこともあり，vue側で正しく処理できないため
            //対象のidを全件取得し，foreachでidに対応するカラムを0から始まるarrayに代入していく.
            $target_ids =($menus->pluck('id'));
            Log::debug("target_ids=".$target_ids);
            foreach($target_ids as $target_id){
                $response_menu[] = $menus[$target_id-1];
            }
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
