<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class AuthController extends Controller
{
    //Register page
    public function register_page(){
        return view('register');
    }

    //Login page
    public function login_page(){
        return view('login');
    }

    //Register
    public function register(){

    }

    //Login
    public function login(){

    }

    //Logout
    public function logout(){

    }
}
