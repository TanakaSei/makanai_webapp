<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\User_Category;

use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Log;

class SettingController extends Controller
{
    public function index(Request $request){
        $user_id=(int)$request->params['id'];
        $user_record = User::where('id', $user_id)->first();

    }
    public function store(Request $request){
        //$user_id=(int)$request->id;
        //$select_num = $request->select_num;
        //Log::debug("select_num:".$select_num);
        //Log::debug("user_id:".$request->params['id']);
        //Log::debug("request:\n".$request);
        //以下の方法でないとidとselect_numが取得できない
        //postの場合のみ？
        $user_id=(int)$request->params['id'];
        $select_num = $request->params['select_num'];
        if(!is_null($select_num)){
            $user_record = User::where('id', $user_id)->first();
            $user_record->select_num = $select_num;
            $user_record->save();
            return 0;
        }
        else{
            return -1;
        }
    }
}
