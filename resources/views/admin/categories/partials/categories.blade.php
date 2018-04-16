@foreach ($categories as $category_list)
    <option value="{{$category_list->id or ""}}"

            {{--если существует id - это редактирование категории--}}
            @isset($category->id)

            {{--если равно - значит данная категория - родительская--}}
            @if ($category->parent_id == $category_list->id)
            selected=""
            @endif

            {{--если id совпадает - скрываем отображение--}}
            @if ($category->id == $category_list->id)
            hidden=""
            @endif

            @endisset

    >
        {{--{!! для сохранения html разметки!!}--}}
        {!! $delimiter or "" !!}{{$category_list->title or ""}}
    </option>

    {{--Вывод бесконечной вложенности категорий--}}
    {{--обращаемся к методу children, который создавали в модели--}}

    @if (count($category_list->children) > 0)
        если есть хоть одна вложенная категория, делаем рекурсию
        @include('admin.categories.partials.categories', [
              'categories' => $category_list->children,
              'delimiter'  => ' - ' . $delimiter
            ])
    @endif
@endforeach