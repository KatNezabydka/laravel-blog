@extends('admin.layouts.app_admin')

@section('content')

    <div class="container">

        {{--Компонент с хлебными крошками и заголовком--}}
        @component('admin.components.breadcrumb')
            @slot('title') Список новостей @endslot
            @slot('parent') Главная @endslot
            @slot('active') Новости @endslot
        @endcomponent

        <hr/>
        {{--кнопка для создания категории--}}
        {{--route('admin.category.index') - так как роут типа ресурс--}}
        <a href="{{route('admin.article.create')}}" class="btn btn-primary pull-right">
            <i class="fa fa-plus-square-o"></i> Создать новость </a>
        {{--таблица для формирования списка категорий--}}
        <table class="table table-striped">
            <thead>
            <th>Наименование</th>
            <th>Публикация</th>
            <th class="text-right">Действие</th>
            </thead>
            <tbody>
            @forelse($articles as $article)
                <tr>
                    <td>{{$article->title}}</td>
                    <td>{{$article->published}}</td>
                    <td class="text-right">
                        {{--Кнопка удаление категории c onsubmit - спрашиваем подтверждения на удаления категории--}}
                        <form onsubmit="if(confirm('Удалить?')){ return true }else{return false}"
                              action="{{route('admin.article.destroy', $article)}}" method="post">
                            <input type="hidden" name="_method" value="DELETE">
                            {{ csrf_field() }}
                            {{--ссылка на редактирование категории; находится внутри формы для верстки--}}
                            {{--вместо ['id'=>$category->id] - указываем коллекцию категорий--}}
                            <a class="btn btn-default" href="{{route('admin.article.edit', $article)}}">
                                <i class="fa fa-edit"></i></a>
                            <button type="submit" class="btn"><i class="fa fa-trash-o"></i> </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center"><h2>Данные отсутствуют</h2></td>
                </tr>
            @endforelse
            </tbody>
            <tfoot>
            <tr>
                <td colspan="5">
                    <ul class="pagination pull-right">{{ $articles->links() }}</ul>
                </td>
            </tr>
            </tfoot>
        </table>
    </div>
@endsection