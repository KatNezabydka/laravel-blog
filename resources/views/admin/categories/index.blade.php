@extends('admin.layouts.app_admin')

@section('content')

    <div class="container">

        {{--Компонент с хлебными крошками и заголовком--}}
        @component('admin.components.breadcrumb')
            @slot('title') Список категорий @endslot
            @slot('parent') Главная @endslot
            @slot('active') Категории @endslot
        @endcomponent

        <hr/>
        {{--кнопка для создания категории--}}
        {{--route('admin.category.index') - так как роут типа ресурс--}}
        <a href="{{route('admin.category.create')}}" class="btn btn-primary pull-right">
            <i class="fa fa-plus-square-o"></i> Создать категорию </a>
        {{--таблица для формирования списка категорий--}}
        <table class="table table-striped">
            <thead>
            <th>Наименование</th>
            <th>Публикация</th>
            <th class="text-right">Действие</th>
            </thead>
            <tbody>
            @forelse($categories as $category)
                <tr>
                    <td>{{$category->title}}</td>
                    <td>{{$category->published}}</td>
                    <td class="text-right">
                        {{--Кнопка удаление категории c onsubmit - спрашиваем подтверждения на удаления категории--}}
                        <form onsubmit="if(confirm('Удалить?')){ return true }else{return false}"
                              action="{{route('admin.category.destroy', $category)}}" method="post">
                            <input type="hidden" name="_method" value="DELETE">
                            {{ csrf_field() }}
                            {{--ссылка на редактирование категории; находится внутри формы для верстки--}}
                            {{--вместо ['id'=>$category->id] - указываем коллекцию категорий--}}
                            <a class="btn btn-default" href="{{route('admin.category.edit', $category)}}">
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
                    <ul class="pagination pull-right">{{ $categories->links() }}</ul>
                </td>
            </tr>
            </tfoot>
        </table>
    </div>
@endsection