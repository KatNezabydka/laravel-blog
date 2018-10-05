@extends('layouts.app')

@section('content')
    {{--PRIVATE CHAT LARAVEL ECHO--}}
    <div class="container">
        @if (Auth::check())
        <private-chat :room="{{$room}}" :user="{{ Auth::user() }}"></private-chat>
        @endif
    </div>

@endsection