@extends('layout')

@section('title')
    Изменение данных пользователя
@endsection

@section('content')

    <div class="flex">
        <div class="left">
            <form action="{{ route('personal_area_update') }}" method="POST">
                <fieldset>
                    <legend>Изменение данных</legend>
                    {{ csrf_field() }}
                    <p class="error">{{ $errors->register->first('username') }}</p>
                    <input type="text" name="username" value="{{ $data->user->username }}" placeholder="Имя пользователя">

                    <p class="error">{{ $errors->register->first('email') }}</p>
                    <input type="text" name="email" value="{{ $data->user->email }}" placeholder="Почта пользователя">


                    <input type="text" value="{{ $data->user->login }}" placeholder="Логин пользователя" disabled>

                    <p class="error">{{ $errors->register->first('password') }}</p>
                    <input type="password" name="password" placeholder="Пароль пользователя">

                    <p class="error">{{ $errors->register->first('password_check') }}</p>
                    <input type="password" name="password_check" placeholder="Подтверждение пароля">

                    <input type="submit" value="Изменить данные">
                </fieldset>
            </form>
        </div>
        <div class="right">
            <a href="{{ route('personal_area') }}"><h3>Личный кабинет</h3></a>
        </div>
    </div>

@endsection
