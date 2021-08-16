@extends('layout')

@section('title')
    Жанры
@endsection

@section('script')
    <script>
        function add_genre(){
            let genre = JSON.stringify({
                'genre':document.querySelector('input[name=genre]').value
            });
            let xhr = new XMLHttpRequest;
            xhr.open("POST","{{ route('genre_add') }}",true);
            xhr.setRequestHeader("content-type","application/json");
            xhr.setRequestHeader("X-CSRF-TOKEN","{{ csrf_token() }}");
            xhr.onreadystatechange = function(){
                if(xhr.readyState != 4) return;
                //Data Parsing
                let data = JSON.parse(xhr.responseText)
                //Обращение к элементам через цикл
                document.querySelectorAll(".error").forEach(element => element.innerHTML = "");
                switch(xhr.status){
                    case 200:
                        //Вывод сообщения в класс message о успешном добавлении в игры
                        document.querySelector(".message").innerHTML = data.message;
                        //Очистка формы
                        document.querySelector('input[name=genre]').value = '';
                        //Вывод всех жанров
                        out_genres(data.genres)
                    break;
                    case 422:
                        for(key in data.errors){
                            //Вывод ошибок
                            document.getElementById(key).innerHTML = data.errors[key][0];
                        }
                    break;
                }
            };
            xhr.send(genre);
        }
        function out_genres(data){
            //Очистка select
            document.querySelector('select[name=genre_id]').innerHTML = ''
            //
            let out = `<option disabled selected>Жанры</option>`
            //Конкатинация данных(обьеденение данных)
            data.forEach(genre =>{
                out += `<option value="${genre.id}">${genre.genre}</option>`
            });
            //Вывод жанров
            document.querySelector('select[name=genre_id]').innerHTML = out;
        }

        function delete_genre(){
            let genre = document.querySelector('select[name=genre_id]').value;
            let xhr = new XMLHttpRequest;
            xhr.open("GET","{{ route('genre_delete') }}?genre_id=" + genre ,true);
            xhr.send();
            xhr.onreadystatechange = function(){
                if(xhr.readyState !=4 ) return;
                if(xhr.responseText == '') return;
                //Data Parsing
                let data = JSON.parse(xhr.responseText);

                if(xhr.status === 200){
                    //Вывод сообщения и вывод жанров
                    document.querySelector(".message").innerHTML = data.message;
                    //Вывод всех жанров
                    out_genres(data.genres);
                };
            };
        }
    </script>
@endsection


@section('content')

    <form class='center' onsubmit="return false">

        <fieldset>
            <legend>Добавление жанра</legend>
            <p class="error" id="genre"></p>
            <input type="text" name="genre" placeholder="Жанр">
            <input type="button" value="Добавить" onclick="add_genre()">
        </fieldset>
        <br>

        <fieldset>
            <legend>Удаление жанра</legend>
            <select name="genre_id">
                <option disabled selected>Жанры</option>
                @foreach($data->genres as $val)
                    <option value="{{ $val->id }}">{{ $val->genre }}</option>
                @endforeach
            </select>
            <input type="button" value="Удалить" onclick="delete_genre()">
        </fieldset>

    </form>

@endsection
