<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\GameController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware'=>'session'],function(){

    //Main page
    Route::get('/',[MainController::class,'main_page'])->name('main_page');

    //Register page
    Route::get('/register',[AuthController::class,'register_page' ])->name('register_page');

    //Register
    Route::post('/register',[AuthController::class,'register' ])->name('register');

    //Login page
    Route::get('/login',[AuthController::class,'login_page' ])->name('login_page');
    //Login
    Route::post('/login',[AuthController::class,'login' ])->name('login');

    //Auth Group
    Route::group(["middleware"=>"auth"],function(){

        Route::get('/game/add',[GameController::class,'game_add_page'])->name('game_add_page');

        Route::post('/game/add',[GameController::class,'game_add'])->name('game_add');

        //Personal Area
        Route::get('/personal_area',[UserController::class,'personal_area'])->name('personal_area');

        //Страница обновления пользовательских данных
        Route::get('/personal_area/update',[UserController::class,'personal_area_update_page'])->name('personal_area_update_page');

        //Личный кабинет
        Route::post('personal_area/update',[UserController::class,'personal_area_update'])->name('personal_area_update');

        //Logout
        Route::get('/logout',[AuthController::class,'logout' ])->name('logout');

        //Удаление пользователя
        Route::get('/personal_area/delete',[UserController::class,'personal_area_delete'])->name('personal_area_delete');

    });

});


