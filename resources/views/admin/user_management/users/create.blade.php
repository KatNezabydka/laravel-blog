@extends('admin.layouts.app_admin')

@section('content')
    <div class="container">
        {{--Компонент с хлебными крошками и заголовком--}}
        @component('admin.components.breadcrumb')
            @slot('title') Создание пользователя @endslot
            @slot('parent') Главная @endslot
            @slot('active') Пользователь @endslot
        @endcomponent

        <hr/>

        <form id="form_id" class="form-horizontal" action="{{ route('admin.user_management.user.store') }}" method="post">
            {{ csrf_field() }}

            {{--Form include--}}
            @include('admin.user_management.users.partials.form')
        </form>

    </div>
@endsection