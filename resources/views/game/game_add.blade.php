@extends('layout')

@section('title')
    Добавление игры
@endsection

@section('script')

    <script>
        function game_add(){
            //Получание данных по id формы
            let formData = new FormData(document.forms['game_add']);

            //Создание экземпляра запроса
            let xhr = new XMLHttpRequest;

            //Открытие запроса
            xhr.open("POST","{{ route('game_add') }}",true);

            //Заголовки(Headers)
            xhr.setRequestHeader("X-CSRF-TOKEN","{{ csrf_token() }}")

            //Обработка результата запроса
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
                        //Очистка формы после добавление
                        e.target.reset();
                    break;
                    case 422:
                        for(key in data.errors){
                            //Вывод ошибок
                            document.getElementById(key).innerHTML = data.errors[key][0];
                        }
                    break;
                }
                console.log(xhr.status, xhr.responseText);
            };
            //Отправка запроса серверу
            xhr.send(formData);

            //Отмена submit в форме
            return false;
        }
    </script>

@endsection


@section('content')

    <form class="center" id="game_add" action="{{ route('game_add') }}" onsubmit="return game_add();">
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

            <input type="submit" value="Добавить">
        </fieldset>
    </form>


@endsection
