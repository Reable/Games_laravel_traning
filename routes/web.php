<?php

use App\Http\Controllers\GenreController;
use App\Http\Controllers\ModerationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\DeveloperController;
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

        Route::get('/developer/add/',[DeveloperController::class,'developer_add_page'])->name('developer_add_page');
        //
        Route::post('/developer/add/',[DeveloperController::class,'developer_add'])->name('developer_add');

        //Personal Area
        Route::get('/personal_area',[UserController::class,'personal_area'])->name('personal_area');

        //Страница обновления пользовательских данных
        Route::get('/personal_area/update',[UserController::class,'personal_area_update_page'])->name('personal_area_update_page');

        //Личный кабинет
        Route::post('personal_area/update',[UserController::class,'personal_area_update'])->name('personal_area_update');

        //Удаление пользователя
        Route::get('/personal_area/delete',[UserController::class,'personal_area_delete'])->name('personal_area_delete');

        //Модераторские группы
        Route::group(['middleware'=>'moderation'],function(){

            Route::get('moderation',[ModerationController::class,'moderation_page'])->name('moderation_page');


            Route::get('/genre',[GenreController::class,'genre_page'])->name('genre_page');
            Route::get('/genre/delete',[GenreController::class,'genre_delete'])->name('genre_delete');
            Route::post('/genre/add',[GenreController::class,'genre_add'])->name('genre_add');



        });



        //Logout
        Route::get('/logout',[AuthController::class,'logout' ])->name('logout');
    });

});


