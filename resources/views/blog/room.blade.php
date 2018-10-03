@extends('layouts.app')

@section('content')

    {{--PRIVATE CHAT LARAVEL ECHO--}}
    <div class="container">
        <private-chat :room="{{$room}}"></private-chat>
    </div>

@endsection