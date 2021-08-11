<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\UserModel;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    //Register page
    public function register_page(){
        return view('auth.register');
    }

    //Login page
    public function login_page(){
        return view('auth.login');
    }

    //Register
    public function register(Request $request){
        //Валидация данных
        $validator = Validator::make($request->all(),[
            'username'=>'required|string|max:100|min:3',
            'email'=>'required|email|max:100',
            'login'=>'required|string|max:100|min:3|unique:users,login',
            'password'=>'required|string|max:100|min:3/required_with:password_check|same:password_check',
            'password_check'=>'required|string|max:100|min:3',
        ]);
        //Вывод ошибок валидации
        if($validator->fails()){
            return redirect()->route('register_page')->withErrors($validator,'register');
        }
        //Создание новой модели
        $user = New UserModel();
        //Добавление данных
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->login = $request->input('login');
        $user->password = bcrypt($request->input('password'));
        $user->role = "user";
        //Сохранение записей
        $user->save();

        return redirect()->route('register_page')->withErrors('Вы успешно авторизовались','message');

    }

    //Login
    public function login(Request $request){

        //Получение данных из базы данных
        $login = $request->input('login');
        $password = $request->input('password');

        //Проверка данных(Auth)
        if(Auth::attempt(['login'=>$login,'password'=>$password],true)){
            //В случае авторизации
            return redirect()->route('main_page')->withErrors('Вы успешно авторизировались','message');
        }//Если не авторизовались
        else return redirect()->route('login_page')->withErrors('Ошибка логина или пароля','login');


    }

    //Logout
    public function logout(){

    }
}
