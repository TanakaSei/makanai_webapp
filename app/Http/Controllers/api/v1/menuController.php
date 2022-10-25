<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class menuController extends Controller
{   
    
    @param Request $request
    @return void

    public function create(Request $request){
        $member = Menber::create([
            'menu_name' => $request->menu_name,
            'category' => $request->category,
        ]);

        return responce(->json($menber))
    }

    @param Request $request
    @return void
    
    public function fetch(Request $request){

    }

}
