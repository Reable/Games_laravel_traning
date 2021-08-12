<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class SessionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        //Проверка на авторизацию
        if(Auth::check()){
            $user = Auth::user();
            $user_id = $user->id;
            $role = $user->role;
        }else{
            $user_id = -1;
            $role = 'guest';
        }
        //Передача переменных всем представлениям
        view()->share(['role'=>$role,'user_id'=>$user_id]);

        return $next($request);
    }
}
