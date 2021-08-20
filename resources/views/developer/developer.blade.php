@extends("layout")

@section('title')
    Страница разроботчика
@endsection

@section('content')

    <div class="wrap">
        <h2>Разроботчик {{$data->developer->developer_title}}</h2><br>
        <h3>Год основания {{$data->developer->developer_foundation}}</h3><br>
        <h3>Описание:</h3>
        <p> {{$data->developer->developer_description}}</p>
    </div>
    <div class="wrap">
        <h2>Игры разроботчика</h2><br>
        <div class="games">
            @if(count($data->games) == 0)
                <p>Данные отсутствуют</p>
            @else
                @foreach($data->games as $val)
                    <div class="game">
                        <a href="{{route('game_page',['id'=>$val->id])}}">
                            <div class="image">
                                <img src="{{asset($val->game_cover)}}">
                            </div>
                            <div class="title">
                                <h3>{{$val->game_title}}</h3>
                            </div>
                        </a>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection
