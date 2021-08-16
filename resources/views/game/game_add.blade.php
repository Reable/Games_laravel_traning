@extends('layout')

@section('title')
    Добавление игры
@endsection
@section('script')

    <script>
        let genres = []

        function game_add(e){
            let formData = new FormData(document.forms['game_add']);
            formData.append('genres', genres);
            let xhr = new XMLHttpRequest;
            xhr.open("POST","{{ route('game_add') }}",true);
            xhr.setRequestHeader("X-CSRF-TOKEN","{{ csrf_token() }}")
            xhr.onreadystatechange = function(){
                if(xhr.readyState !=4) return;
                let data = JSON.parse(xhr.responseText)
                document.querySelectorAll(".error").forEach(element => element.innerHTML = "");
                switch(xhr.status){
                    case 200:
                        document.querySelector(".message").innerHTML = data.message;
                        document.querySelector('.genres').innerHTML = '';
                        genres = [];
                        e.target.reset()
                    break;
                    case 422:
                        for(key in data.errors){
                            document.getElementById(key).innerHTML = data.errors[key][0];
                        }
                    break;
                }
            };
            //Отправка запроса серверу
            xhr.send(formData);

            //Отмена submit в форме
            return false;
        }
        //Add genre
        function add_genre(){
            let genre = document.querySelector('#genre'),text = ""
            //2 проверки ыторая на поиск этих же данных
            if(genre.value === "Жанры") return; if(genres.indexOf(genre.value) !== -1) return;
            for(let i = 0; i < genre.options.length;i++){
                if(genre.options[i].value == genre.value){
                    text = genre.options[i].innerText;
                }
            }
            genres.push(genre.value);
            let out = `<div class="genre" onclick="delete_genre(event)">${text}</div>`;
            document.querySelector(".genres").innerHTML += out;
        }

        //Delete genre
        function delete_genre(e){

            let genre = document.querySelector('#genre'),text = e.target.innerText, value = -1;
            for(let i = 0; i < genre.options.length;i++){
                if(genre.options[i].innerText === text){
                    value = genre.options[i].value;
                }
            }
            let index = genres.indexOf( value )
            //splise - удаление нужного элемента
            genres.splice(index, 1)
            //Delete div
            e.target.outerHTML = "";
        }
    </script>

@endsection

@section('content')

    <form class="center" id="game_add" action="{{ route('game_add') }}" onsubmit="return game_add(event);">
        <fieldset>
            <legend>Добавить игру</legend>

            <p class="error" id="cover"></p>
            <p>Обложка игры</p>
            <input type="file" name="cover">

            <p class="error" id="title"></p>
            <input type="text" name="title" placeholder="Название игры">

            <p class="error" id="year_release"></p>
            <input type="number" name="year_release" placeholder="Дата выхода игры">

            <p class="error" id="description"></p>
            <textarea name="description" placeholder="Описание"></textarea>

            <p class="error" id="genres"></p>
            <div class="part">
                <select id="genre">
                    <option disabled selected>Жанры</option>
                    @foreach($data->genres as $val)
                        <option value="{{ $val->id }}">{{ $val->genre }}</option>
                    @endforeach
                </select>
                <input type="button" value="Добавить" onclick="add_genre()">
            </div>
            <div class="genres"></div>
            <p class="error" id="developer_id"></p>
            <select name="developer_id">
                <option disabled selected>Разроботчики</option>
                @foreach($data->developers as $val)
                    <option value="{{ $val->id }}">{{ $val->developer_title }}</option>
                @endforeach
            </select>

            <input type="submit" value="Добавить">
        </fieldset>
    </form>


@endsection
