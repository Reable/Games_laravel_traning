<?php

namespace App\Http\Controllers;

use App\Models\DeveloperModel;
use App\Models\GameModel;
use Illuminate\Http\Request;

class MainController extends Controller
{
    //
    public function main_page(){
        //Передача разроботчиков только одобренных
        //orderBy
        $developers = DeveloperModel::where('state','1')->orderBy('updated_at','DESC')->get();
        $games = GameModel::where('state','1')->orderBy('updated_at','DESC')->get();

        //Составление обьекта
        $data = (object)[
            'games' => $games,
            'developers' => $developers,
        ];

        return view('index',['data'=>$data]);
    }
}
