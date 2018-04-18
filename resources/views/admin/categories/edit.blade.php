@extends('admin.layouts.app_admin')

@section('content')
    <div class="container">
        {{--Компонент с хлебными крошками и заголовком--}}
        @component('admin.components.breadcrumb')
            @slot('title') Редактирование категории @endslot
            @slot('parent') Главная @endslot
            @slot('active') Категории @endslot
        @endcomponent

        <hr/>

        <form id="form_id" class="form-horizontal" action="{{ route('admin.category.update', $category) }}" method="post">
            {{--Добавляем метод, который обрабатывать--}}
            <input type="hidden" name="_method" value="put">
            {{ csrf_field() }}

            {{--Form include--}}
            @include('admin.categories.partials.form')
        </form>

    </div>
@endsection