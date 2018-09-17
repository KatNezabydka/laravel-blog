@extends('admin.layouts.app_admin')

@section('content')
    <div class="container">
        {{--Компонент с хлебными крошками и заголовком--}}
        @component('admin.components.breadcrumb')
            @slot('title') Создание новости @endslot
            @slot('parent') Главная @endslot
            @slot('active') Новости @endslot
        @endcomponent

        <hr/>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="form_id" class="form-horizontal" action="{{ route('admin.article.store') }}" method="post">
            {{ csrf_field() }}

            {{--Form include--}}
            @include('admin.articles.partials.form')
            {{--храним id пользователя, который создает запись--}}
            <input type="hidden" name="created_by" value="{{Auth::id()}}">
        </form>

    </div>
@endsection