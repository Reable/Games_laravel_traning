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
        $developers = DeveloperModel::all();
        $games = GameModel::all();

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
    //Вновь отправить на модерацию
    public function condemn_developer(Request $request){
        $id = $request->input('developer_id');
        $developer = DeveloperModel::find($id);
        $developer->state = 0;
        $developer->save();
        return redirect()->route('moderation_page')->withErrors('Разроботчик '.$developer->developer_title.' отправлен на модерацию','message');
    }
    //Вновь отправить на модерацию
    public function condemn_game(Request $request){
        $id = $request->input('game_id');
        $game = GameModel::find($id);
        $game->state = 0;
        $game->save();
        return redirect()->route('moderation_page')->withErrors('Игра '.$game->game_title.' отправлен на модерацию','message');
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
