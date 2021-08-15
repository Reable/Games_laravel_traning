<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

//Models
use App\Models\DeveloperModel;
class DeveloperController extends Controller
{
    //
    public function developer_add_page(){
        return view('developer.developer_add');
    }
    public function developer_add(Request $request){
        $validator = Validator::make($request->all(),[
            'title'=>'required|string|max:100',
            'year_release'=>'required|numeric|redux:/\d{4}/',
            'description'=>'required|string',
        ]);
        if($validator->fails()){
            return response()->json([
                'message'=>'Validation errors',
                'errors'=>$validator->errors()
            ],422);
        }

        $developer = new DeveloperModel();
        $developer->developer_title = $request->input('title');
        $developer->developer_release = $request->input('year_release');
        $developer->developer_description = $request->input('description');
        $developer->save();

        return response()->json([
            'message'=>'Разработчик успешно добавлен'
        ],200);
    }
}
