@extends("layout")

@section('title')
    Регистрация
@endsection

@section('content')

        <form class="register" action="{{ route('register') }}" method="POST">
            <fieldset>
                <legend>Регистрация</legend>
                {{ csrf_field() }}
                <p class="error">{{ $errors->register->first('username') }}</p>
                <input type="text" name="username" placeholder="Имя пользователя">

                <p class="error">{{ $errors->register->first('email') }}</p>
                <input type="text" name="email" placeholder="Почта пользователя">

                <p class="error">{{ $errors->register->first('login') }}</p>
                <input type="text" name="login" placeholder="Логин пользователя">

                <p class="error">{{ $errors->register->first('password') }}</p>
                <input type="password" name="password" placeholder="Пароль пользователя">

                <p class="error">{{ $errors->register->first('password_check') }}</p>
                <input type="password" name="password_check" placeholder="Подтверждение пароля">

                <input type="submit" value="Зарегестрироваться">
                <p class="center">Уже зарегестрированны? Тогда <a class="underline" href="{{ route('login_page') }}">войдите</a></p>
            </fieldset>
        </form>


@endsection


