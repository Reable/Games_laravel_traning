<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//Models
use App\Models\UserModel;
use App\Models\DeveloperModel;
use App\Models\GameModel;

class ModerationController extends Controller
{
    //
    public function moderation_page(){
        //Получение данных
        $users = UserModel::all();
        $developers = DeveloperModel::where('state','0')->get();
        $games = GameModel::where('state','0')->get();

        $data = (object)[
          'users'     =>    $users,
          'games'     =>    $games,
          'developers'=>$developers
        ];

        return view('moderation.moderation',['data'=>$data]);
    }

    //Одобрение разроботчика
    public function approve_developer(Request $request){
        $developer_id = $request->input('developer_id');
        $developer = DeveloperModel::find($developer_id);
        $developer->state = 1;
        $developer->save();
        return redirect()->route('moderation_page')->withErrors('Разработчик '. $developer->developer_title .' одобрен','message');
    }

    //Одобрение игры
    public function approve_game(Request $request){
        $game_id = $request->input('game_id');
        $game = GameModel::find($game_id);
        $game->state = 1;
        $game->save();
        return redirect()->route('moderation_page')->withErrors('Игра '. $game->game_title .' одобрена','message');

    }

    //Удаление пользователя по выбору
    public function delete_user(Request $request){
        //
        $user_id = $request->input('user_id');
        $user = UserModel::find($user_id);
        $login = $user->login;
        $user->delete();

        return redirect()->route('moderation_page')->withErrors('Пользователь '. $login .' успешно удален','message');
    }

}
