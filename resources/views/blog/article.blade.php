@extends('layouts.app')

@section('title', $article->meta_title)
@section('meta_keyword', $article->meta_keyword)
@section('meta_description', $article->meta_description)

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h1>{{ $article->title }}</h1>
                <p>{!! $article->description !!}</p>
                <div>Автор статьи: <span>{{ $article->user->name }}</span></div>
                {{--<div>Количество просмотров: {{$article->viewed}}</div>--}}
            </div>
        </div>
    </div>
    @if ($errors->any())
        <div class="container">
            <div class="row ">
                <div class="col-sm-12">
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- START COMMENTS -->

    <div class="container">
        <div class="col-md-8">
            @if(count($comments) > 0)
                <div>Комментарии:</div>
                @foreach($comments as $comment)
                <h3 id="comments-title">
                    {{ $comment->text }}
                </h3>
                <br>
                @endforeach
            @endif
            <form method="POST" action="{{ route('comment.store') }}">
                @csrf
                @if(!Auth::check())

                    <div class="form-group row">
                        <label for="name" class="col-sm-4 col-form-label text-md-right">Имя</label>
                        <div class="col-md-6">
                            <input id="name" class="form-control" name="name" required autofocus>
                        </div>

                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-sm-4 col-form-label text-md-right">E-Mail</label>
                        <div class="col-md-6">
                            <input id="email" type="email"
                                   class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                                   value="{{ old('email') }}" required autofocus>

                            @if ($errors->has('email'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                @endif

                <div class="form-group row">
                    <label for="text" class="col-md-4 col-form-label text-md-right">Ваш комментарий</label>

                    <div class="col-md-6">
                        <textarea id="text" name="text" cols="45" rows="8"></textarea>
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-8 offset-md-4">

                        <input id="comment_post_ID" type="hidden" name="comment_post_ID" value="{{ $article->id }}"/>
                        <input id="comment_parent" type="hidden" name="comment_parent" value="0"/>
                        <button type="submit" class="btn btn-primary">Комментировать</button>

                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
