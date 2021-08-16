@extends('layout')

@section('title')
    Добавление разработчика
@endsection

@section('script')
    <script>
        function add_developer(e){
            //Получение всех полей
            let form = document.forms[0];
            //Составление обьекта разработчика
            let dataJSON = JSON.stringify({
                'title': form.elements['title'].value,
                'year_release': form.elements['year_release'].value,
                'description': form.elements['description'].value,
            });
            let xhr = new XMLHttpRequest;
            xhr.open("POST","{{ route('developer_add') }}",true);
            xhr.setRequestHeader("content-type","application/json");
            xhr.setRequestHeader("X-CSRF-TOKEN","{{ csrf_token() }}");
            xhr.onreadystatechange = function(){
                if(xhr.readyState !== 4) return;
                //Data Parsing
                let data = JSON.parse(xhr.responseText)
                //Обращение к элементам через цикл
                document.querySelectorAll(".error").forEach(element => element.innerHTML = "");
                switch(xhr.status){
                    case 200:
                        //Вывод сообщения в класс message о успешном добавлении в игры
                        document.querySelector(".message").innerHTML = data.message;
                        //Очистка формы
                        e.target.reset();
                        break;
                    case 422:
                        for(key in data.errors){
                            //Вывод ошибок
                            document.getElementById(key).innerHTML = data.errors[key][0];
                        }
                    break;
                }
            };
            xhr.send(dataJSON);
            return false
        }
    </script>
@endsection

@section('content')
    <form class="center" onsubmit="return add_developer(event)">
        <fieldset>
            <legend>Добавить разработчика</legend>
            <p class="error" id="title"></p>
            <input type="text" placeholder="Название" name="title">


            <p class="error" id="year_release"></p>
            <input type="text" placeholder="Год основания" name="year_release">

            <p class="error" id="description"></p>
            <textarea placeholder="Описание" name="description"></textarea>

            <input type="submit" value="Добавить">
        </fieldset>

    </form>
@endsection
