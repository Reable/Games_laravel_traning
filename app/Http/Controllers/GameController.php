<?php

namespace App\Http\Controllers;

use App\Models\DeveloperModel;
use App\Models\GenreModel;
use Illuminate\Http\Request;
//Modules
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

//Models
use App\Models\GameModel;
use App\Models\GameGenreModel;

class GameController extends Controller
{
    //Add game page
    public function game_add_page(){
        $genres = GenreModel::all();
        $developer = DeveloperModel::where("state","1")->get();
        $data = (object)[
            'genres'=>$genres,
            'developers'=>$developer
        ];

        return view('game/game_add',['data'=>$data]);
    }
    public function game_add(Request $request){
        $validator = Validator::make($request->all(),[
            "cover"=>'required|max:2048|mimes:jpg,png',
            'title'=>'required|string',
            'year_release'=>'required|numeric|regex:/^20\d{2}$/',
            'description'=>'required|string',
            'genres'=>'required',
            'developer_id'=>'required|numeric'
        ]);

        if($validator->fails()){
            return response()->json([
                'message'=>'Validation errors',
                'errors'=>$validator->errors(),
            ],422);
        }
        $image_name = '1_' . time() .'_' . $request->file('cover')->extension();
        $path = 'public/images/' . $image_name;
        $game= new GameModel();

        $game->user_id = Auth::id();
        $game->game_cover = $path;
        $game->game_title = $request->input('title');
        $game->game_release = $request->input('year_release');
        $game->game_description = $request->input('description');
        $game->developer_id = $request->input('developer_id');
        $game->save();

        //Add genres
        $genres = explode(',', $request->input('genres'));
        foreach($genres as $id){
            $ggm = new GameGenreModel();
            $ggm->game_id = $game->id;
            $ggm->genre_id = $id;
            $ggm->save();
        }


        $request->file('cover')->move(public_path('images/'), $image_name);
        return response()->json([
            'message'=>'Игра успешно добавлена'
        ],200);
    }
}
