<?php

namespace App\Http\Controllers;

use App\Models\GenreModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GenreController extends Controller
{
    //Genre add
    public function genre_page(){
        $genre = GenreModel::all();

        $data = (object)[
          'genres'=>$genre
        ];

        return view('moderation/genre',['data'=>$data]);
    }
    public function genre_add(Request $request){
        $validator = Validator::make($request->all(),[
           'genre'=>'required|string|max:100|unique:genres,genre'
        ]);
        if($validator->fails()){
            return response()->json([
               'message'=>'Validation errors',
               'errors'=>$validator->errors(),
            ],422);
        }

        $genre = new GenreModel();
        $genre->genre = $request->input('genre');
        $genre->save();
        //Получение всех жанров и отдача их представлению
        $genres = GenreModel::all();
        return response()->json([
            'message'=>'Жанр успешно добавлен',
            'genres'=>$genres
        ],200);
    }
    public function genre_delete(Request $request){
        //Получение id
        $genre_id = $request->input('genre_id');

        //Удаление жанров
        $genre = GenreModel::find($genre_id);
        if($genre == NULL) return;
        $genre->delete();

        //Получение всех записей
        $genres = GenreModel::all();
        return response()->json([
            'message'=>'Жанр успешно удален',
            'genres'=>$genres
        ],200);
    }
}
