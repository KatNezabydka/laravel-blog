@extends('admin.layouts.app_admin')

@section('content')

    <div class="container">

        {{--Компонент с хлебными крошками и заголовком--}}
        @component('admin.components.breadcrumb')
            {{--@slot('title') Список пользователей @endslot/--}}
            @slot('title') Персональные данные @endslot

        @slot('parent') Главная @endslot
            @slot('active') Вы @endslot
        @endcomponent

        <hr/>
        {{--кнопка для создания категории--}}
        {{--route('admin.category.index') - так как роут типа ресурс--}}
        {{--<a href="{{route('admin.user_management.user.create')}}" class="btn btn-primary pull-right">--}}
            {{--<i class="fa fa-plus-square-o"></i> Создать пользователя </a>--}}
        {{--таблица для формирования списка категорий--}}
        <table class="table table-striped">
            <thead>
            <th>Имя</th>
            <th>Email</th>
            <th class="text-right">Действие</th>
            </thead>
            <tbody>
            {{--@forelse($users as $user)--}}
                <tr>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td class="text-right">
                        <a class="btn btn-default" href="{{route('admin.user_management.user.edit', $user)}}">
                            <i class="fa fa-edit"></i></a>
                        {{--Кнопка удаление пользователей c onsubmit - спрашиваем подтверждения на удаления пользователя--}}
                        {{--<form onsubmit="if(confirm('Удалить?')){ return true }else{return false}"--}}
                              {{--action="{{route('admin.user_management.user.destroy', $user)}}" method="post">--}}
                            {{--{{ method_field('DELETE') }}--}}
                            {{--{{ csrf_field() }}--}}
                            {{--ссылка на редактирование пользователя; находится внутри формы для верстки--}}
                           {{----}}
                            {{--<button type="submit" class="btn"><i class="fa fa-trash-o"></i> </button>--}}
                        {{--</form>--}}
                    </td>
                </tr>
            <tr>
                {{--<td>{{$user->user_additional->lastname}}</td>--}}
                {{--<td>{{$user->user_additional->lastname}}</td>--}}
            </tr>
            {{--@empty--}}
                {{--<tr>--}}
                    {{--<td colspan="3" class="text-center"><h2>Данные отсутствуют</h2></td>--}}
                {{--</tr>--}}
            {{--@endforelse--}}
            </tbody>
            <tfoot>
            <tr>
                {{--<td colspan="5">--}}
                    {{--для пагинации указываем коллекцию, которая содержит всех пользователей--}}
                    {{--<ul class="pagination pull-right">{{$users->links()}}</ul>--}}
                {{--</td>--}}
            </tr>
            </tfoot>
        </table>
    </div>
@endsection