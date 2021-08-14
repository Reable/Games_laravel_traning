@extends("layout")

@section('title')
    Авторизация
@endsection

@section('content')

        <form class="center" action="{{ route('login') }}" method="POST">
            <fieldset>
                <legend>Авторизация</legend>
                {{ csrf_field() }}

                <p class="error">{{ $errors->login->first() }}</p>
                <input type="text" name="login" placeholder="Логин пользователя">
                <input type="password" name="password" placeholder="Пароль пользователя">

                <input type="submit" value="Авторизироваться">
                <p class="center">Желаете <a class="underline" href="{{ route('register_page') }}">зарегистрироваться?</a></p>
            </fieldset>
        </form>

@endsection
