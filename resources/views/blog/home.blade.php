@extends('layouts.app')

@section('content')

    <ex-comp></ex-comp>

    <new-comp :articles="{{ $articles }}"></new-comp>
@endsection
