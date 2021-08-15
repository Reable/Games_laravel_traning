<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//Modules
use Illuminate\Support\Facades\Validator;

//Models
use App\Models\GameModel;

class GameController extends Controller
{
    //Add game page
    public function game_add_page(){
        return view('game/game_add');
    }
    public function game_add(Request $request){
        $validator = Validator::make($request->all(),[
            "cover"=>'required|max:2048|mimes:jpg,png',
            'title'=>'required|string',
            'year_release'=>'required|numeric|regex:/\d{4}/',
            'description'=>'required|string'
        ]);
        if($validator->fails()){
            return response()->json([
               'message'=>'Validation errors',
               'errors'=>$validator->errors(),
            ],422);
        }
        //Обработка изображения
        $image_name = '1_' . time() .'_' . $request->file('cover')->extension();
        $path = 'public/images/' . $image_name;

        $game= new GameModel();

        $game->game_cover = $path;
        $game->game_title = $request->input('title');
        $game->game_release = $request->input('year_release');
        $game->game_description = $request->input('description');
        $game->developer_id = 0;

        $game->save();
        //Добавление изображения на сервер
        $request->file('cover')->move(public_path('images/'), $image_name);
        //Отправка ответных данных
        return response()->json([
            'message'=>'Игра успешно добавлена'
        ],200);
    }
}
