@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
@endif

    <label for="">Имя</label>
    {{--value используем if если это будет редактирование данных для заполнения данных в поля--}}
    <input type="text" class="form-control" name="name" placeholder="Имя"
           value="@if(old('name')){{old('name')}}@else{{$user->name or ""}}@endif" required>

    <label for="">Фамилия</label>
    {{--value используем if если это будет редактирование данных для заполнения данных в поля--}}
    <input type="text" class="form-control" name="lastname" placeholder="Фамилия"
           value="@if(old('lastname')){{old('lastname')}}@else{{$user->user_additional->lastname or ""}}@endif" required>

    <label for="">Отлчество</label>
    {{--value используем if если это будет редактирование данных для заполнения данных в поля--}}
    <input type="text" class="form-control" name="patronymic" placeholder="Отчество"
           value="@if(old('patronymic')){{old('patronymic')}}@else{{$user->user_additional->patronymic or ""}}@endif" required>

    <label for="">Email</label>
    <input type="email" class="form-control" name="email" placeholder="Email" value="@if(old('email')){{old('email')}}@else{{$user->email or ""}}@endif" required>


    <label for="">Пароль</label>
    <input type="password" class="form-control" name="password">

    <label for="">Подтверждение пароля</label>
    <input type="password" class="form-control" name="password_confirmation">

    <hr/>

    <input class="btn btn-primary" type="submit" value="Сохранить">
