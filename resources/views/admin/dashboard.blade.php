@extends('admin.layouts.app_admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <div class="jumbotron">
                    <p><span class="label lavel-primary">Категорий {{ $count_categories }}</span></p>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="jumbotron">
                    <p><span class="label lavel-primary">Материалов {{ $count_articles}}</span></p>
                </div>
            </div>
            {{--<div class="col-sm-3">--}}
                {{--<div class="jumbotron">--}}
                    {{--<p><span class="label lavel-primary">Посетителей 0</span></p>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<div class="col-sm-3">--}}
                {{--<div class="jumbotron">--}}
                    {{--<p><span class="label lavel-primary">Сегодня 0</span></p>--}}
                {{--</div>--}}
            {{--</div>--}}
        </div>
        <div class="row">
            <div class="col-sm-6">
                <a class="btn btn-block btn-default" href="{{route('admin.category.create')}}">Создать категорию</a>

                @foreach($categories as $category)
                    {{--ссылка на редактирование категорий--}}
                    <a class="list-group-item" href="{{route('admin.category.edit', $category)}}">
                        {{--Заголовок категории--}}
                        <h4 class="list-group-item-heading">{{$category->title}}</h4>
                        <p class="list-group-item-text">
                            {{--обратная полмирфная связь с новостями--}}
                            Количество новостей в категории
                            {{$category->articles()->count()}}
                        </p>
                    </a>
                @endforeach
            </div>

            <div class="col-sm-6">
                <a class="btn btn-block btn-default" href="{{route('admin.article.create')}}">Создать материал</a>
                @foreach($articles as $article)
                    <a class="list-group-item" href="{{route('admin.article.edit', $article)}}">
                        <h4 class="list-group-item-heading">{{$article->title}}</h4>
                        <p class="list-group-item-text">
                            Категория:
                            {{--pluck() - извлекает значение для ключа title, т.к. он возвращает массив, выведем ее в строку через запятую--}}
                            {{ $article->categories()->pluck('title')->implode(',') }}
                        </p>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endsection