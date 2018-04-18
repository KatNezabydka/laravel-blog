@extends('admin.layouts.app_admin')

@section('content')
    <div class="container">
        {{--Компонент с хлебными крошками и заголовком--}}
        @component('admin.components.breadcrumb')
            @slot('title') Создание новости @endslot
            @slot('parent') Главная @endslot
            @slot('active') Категории @endslot
        @endcomponent

        <hr/>

        <form id="form_id" class="form-horizontal" action="{{ route('admin.article.store') }}" method="post">
            {{ csrf_field() }}

            {{--Form include--}}
            @include('admin.articles.partials.form')
            <input type="hidden" name="created_by" value="{{Auth::id()}}">
        </form>

    </div>
@endsection