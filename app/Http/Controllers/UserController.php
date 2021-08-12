<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //Personal Area
    public function personal_area(){
        $user = Auth::user();
        $data = (object)[
          'user'=>$user,
        ];
        return view('personal_area',['data'=>$data]);
    }
}
