@extends('layouts.app')

@section('title', $category->title . " - DEVELOP")

@section('content')

    <div class="container">
        @forelse($articles as $article)
            <dic class="row">
                <div class="col-sm-12">
                    {{--route('article') - это имя маршрута name('article')--}}
                    {{--второй параметр - это slug часть--}}
                    <h2><a href="{{ route('article', $article->slug) }}">{{ $article->title }}</a></h2>
                    <p>{!! $article->description_short !!}</p>
                </div>
            </dic>
        @empty
<h2 class="text-center">Пусто</h2>
        @endforelse
        {{--отображение пагинации--}}
        {{ $articles->links() }}
    </div>

@endsection
