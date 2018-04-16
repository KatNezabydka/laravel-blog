@extends('admin.layouts.app_admin')

@section('content')

    <div class="container">

        {{--Компонент с хлебными крошками и заголовком--}}
        @component('admin.components.breadcrumb')
            @slot('title') Список категорий @endslot
            @slot('parent') Главная @endslot
            @slot('active') Категории @endslot
        @endcomponent

        <hr />
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
                    <td>
                        {{--ссылка на редактирование категории--}}
                        <a href="{{route('admin.category.edit', ['id'=>$category->id])}}">
                            <i class="fa fa-edit"></i></a>
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