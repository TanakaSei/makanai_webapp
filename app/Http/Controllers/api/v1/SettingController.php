<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\UserCategory;
use App\Models\Category;

use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Log;

class SettingController extends Controller
{
    public function index(Request $request){
        //Log::debug("user:".$request);
        $user_id=(int)$request->id;
        $user_record = UserCategory::where('user_id', '=', $user_id)->get();
        //Log::debug("user:".$user_record);
        return response()->json($user_record);
    }

    public function store(Request $request){
       
        $user_id=(int)$request->params['id'];
        $select_num = $request->params['select_num'];
        $duplication_checked = $request->params['duplication_checked'];
        $category_state = $request->params['category_state'];
        try{
            $user_record = User::where('id', $user_id)->first();
            $user_record->select_num = $select_num;
            $user_record->duplication = $duplication_checked;
            $user_record->save();

            $user_category_setting = UserCategory::where('user_id', $user_id)->get();
            $i = 0;
            foreach($user_category_setting as $hoge){
                //Log::debug($hoge);
                if($category_state[$i] == true){
                    $hoge->setting_boolean = true;
                }else{
                    $hoge->setting_boolean = false;
                }
                $hoge->save();
                $i += 1;
            }
            return 0;
        }catch(Throwable $e){
            return -1;
        }
    }
    public function list(){
        $categories = Category::select('category_name')->get();
        return response()->json($categories);
    }

    public function category_value(Request $request){
        $user_id=(int)$request->id;
        $user_record = UserCategory::where('user_id', '=', $user_id)->get();
        $setting_value = array();
        foreach($user_record as $data){
            if($data['setting_boolean'] == 1){
                $setting_value[] = true;
            }
            else{
                $setting_value[] = false;
            }

        }
        return response()->json($setting_value);
    }
}
