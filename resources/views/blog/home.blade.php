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

    <h1>Чат</h1>
<socket-chat-component></socket-chat-component>
@endsection
