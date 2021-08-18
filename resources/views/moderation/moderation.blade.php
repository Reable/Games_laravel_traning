@extends('layout')

@section('title') Страница модерации @endsection

@section('script')
    <script>
        function delete_user(id){
            let check = confirm('Вы действительно хотите удалить пользователя')
            if(check) location.href = `{{route('moderation_delete_user')}}?user_id=${id}`
        }
    </script>
@endsection
@section('content')
    <div class="flex">
        <div class="left">
            <h2 style="text-align: center">Страница модерации</h2><br>
            <div class="point"><br>
                <h3>Список пользователей</h3><hr>
                @if(count($data->users) == 0)
                    <p>Данные отсутствуют</p>
                @else
                    @foreach($data->users as $val)
                        <div class="structure">
                            <div class="name">
                                <a href="">{{$val->username}}/{{$val->login}}</a>
                            </div>
                            <div class="action">
                                <a onclick="delete_user({{$val->id}})">Удалить</a>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="point"><br>
                <h3>Список разроботчиков</h3><hr>
                @if(count($data->developers) == 0)
                    <p>Данные отсутствуют</p>
                @else
                    @foreach($data->developers as $val)
                        <div class="structure">
                            <div class="name">
                                <a href="">{{$val->developer_title}}</a>
                            </div>
                            <div class="action">
                                <a href="{{route('moderation_approve_developer',['developer_id'=>$val->id])}}">Одобрить</a>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="point"><br>
                <h3>Список Игр</h3><hr>
                @if(count($data->games) == 0)
                    <p>Данные отсутствуют</p>
                @else
                    @foreach($data->games as $val)
                        <div class="structure">
                            <div class="name">
                                <a href="">{{$val->game_title}}/{{$val->game_release}}</a>
                            </div>
                            <div class="action">
                                <a href="{{route('moderation_approve_game',['game_id'=>$val->id])}}">Одобрить</a>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>


        </div>
        <div class="right">
            <a href="{{ route('personal_area') }}"><h3>Назад</h3></a>
        </div>
    </div>
@endsection
