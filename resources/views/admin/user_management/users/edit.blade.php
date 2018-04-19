@extends('admin.layouts.app_admin')

@section('content')
    <div class="container">
        {{--Компонент с хлебными крошками и заголовком--}}
        @component('admin.components.breadcrumb')
            @slot('title') Редактирование пользователя @endslot
            @slot('parent') Главная @endslot
            @slot('active') Пользователи @endslot
        @endcomponent

        <hr/>

        <form class="form-horizontal" action="{{route('admin.user_management.user.update', $user)}}" method="post">
            {{--метод хелпер, генерирует скрытое поле--}}
            {{ method_field('PUT') }}
            {{ csrf_field() }}

            {{-- Form include --}}
            @include('admin.user_management.users.partials.form')
        </form>

    </div>
@endsection