<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //Personal Area
    public function personal_area(){
        $user = Auth::user();
        $data = (object)[
          'user'=>$user,
        ];
        return view('user/personal_area',['data'=>$data]);
    }

    public function personal_area_update_page(){
        $user = Auth::user();
        $data = (object)[
            'user'=>$user,
        ];
        return view('user/update',['data'=>$data]);
    }
    public function personal_area_update(Request $request){
        //Валидация данных
        $validator = Validator::make($request->all(),[
            'username'=>'required|string|max:100|min:3',
            'email'=>'required|email|max:100',
        ]);
        //Вывод ошибок валидации
        if($validator->fails()){
            return redirect()->route('personal_area_update')->withErrors($validator,'register');
        }
        if($request->input('password') != '' || $request->input('password_check') != ''){
            $validator = Validator::make($request->all(),[
                'password'=>'required|string|max:100|min:3/required_with:password_check|same:password_check',
                'password_check'=>'required|string|max:100|min:3',
            ]);
            if($validator->fails()){
                return redirect()->route('personal_area_update')->withErrors($validator,'register');
            }
        }
        //Получение id пользователя
        $user_id = Auth::id();
        //Получение пользователя по id
        $user = UserModel::find($user_id);

        //Изменение данных
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        if($request->input('password') != '')
             $user->password = bcrypt($request->input('password'));
        $user->role = "user";
        //Сохранение измененных данных
        $user->save();

        return redirect()->route('personal_area')->withErrors('Вы изменили данные','message');
    }

    public function personal_area_delete(){
        $user_id = Auth::id();
        $user = UserModel::find($user_id);
        $user->delete();
        Auth::logout();
        return redirect()->route('main_page')->withErrors('Пользователь удален','message');


    }
}
