<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

//Models
use App\Models\DeveloperModel;
use App\Models\GameModel;
class DeveloperController extends Controller
{
    //
    public function developer_page(Request $request){
        $developer_id = $request->route('id');
        $developer = DeveloperModel::find($developer_id);

        //Обработка ошибок
        if($developer == NULL) return redirect()->route('main_page')->withErrors('Такого разроботчика не существует','message');
        if($developer->state == 0){
            if(Auth::check()){
                $user = Auth::user();
                switch ($user->role){
                    case 'admin': break;
                    case 'moderator': break;
                    default: return redirect()->route('main_page')->withErrors('Такого разроботчика не существует','message');

                }
            }else{
                return redirect()->route('main_page')->withErrors('Вы не авторизованы','message');
            }
        }

        $games=GameModel::where('developer_id',$developer_id)->orderBy('updated_at','DESC')->get();
        $data = (object)[
          'developer'=>$developer,
          'games'=>$games
        ];
        return view('developer.developer',['data'=>$data]);
    }
    public function developer_add_page(){
        return view('developer.developer_add');
    }
    public function developer_add(Request $request){
        $validator = Validator::make($request->all(),[
            'title'=>'required|string|max:100',
            'year_foundation'=>'required|numeric|regex:/^20\d{2}$/',
            'description'=>'required|string',
        ]);
        if($validator->fails()){
            return response()->json([
                'message'=>'Validation errors',
                'errors'=>$validator->errors()
            ],422);
        }
        $developer = new DeveloperModel();
        $developer->user_id = Auth::id();
        $developer->developer_title = $request->input('title');
        $developer->developer_foundation = $request->input('year_foundation');
        $developer->developer_description = $request->input('description');
        $developer->save();

        return response()->json([
            'message'=>'Разработчик отправлен на модерацию'
        ],200);
    }
}
