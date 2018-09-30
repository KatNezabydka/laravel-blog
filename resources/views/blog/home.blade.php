@extends('layouts.app')

@section('content')

    {{--<ex-comp></ex-comp>--}}
    {{--<form action="{{ url('/getArticles') }}" method="get">--}}
    {{--<button  type="submit">AJAX</button>--}}
    {{--</form>--}}
    {{--<ajax-comp></ajax-comp>--}}
    {{--<new-comp :articles="{{ $articles }}"></new-comp>--}}

    {{--<h1>Chart Line Component</h1>--}}
    {{--<chartline-comp></chartline-comp>--}}

    {{--<h1>Chart Pie Component</h1>--}}
    {{--<chartpie-comp></chartpie-comp>--}}

    {{--<h1>Socket Component</h1>--}}
    {{--<socket-comp></socket-comp>--}}

    {{--<h1 class="text-center">Чат</h1>--}}
    {{--<socket-chat-component></socket-chat-component>--}}
    {{--<br>--}}
    {{--@if (Auth::check())--}}
        {{--<h1 class="text-center">Чат</h1>--}}
        {{--<h4 class="text-center">пользователь: {{ Auth::user()->email }}</h4>--}}
        {{--список пользователей передаем диначически в компонент - практика такая себе, и выборку так делать НЕ НУЖНО!!!--}}
        {{--<socket-privat-chat-component :users="{{\App\User::select('email', 'id')->where('id', '!=', Auth::id())->get()}}"--}}
                                   {{--:user="{{ Auth::user() }}" ></socket-privat-chat-component>--}}
    {{--@endif--}}


    {{--CHAT LARAVEL ECHO--}}
    <div class="container">
        <chat></chat>
    </div>
    {{--PRIVATE CHAT LARAVEL ECHO--}}
    <div class="container">
        {{--<private-chat></private-chat>--}}
    </div>

@endsection
