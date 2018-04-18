@foreach ($categories as $category)

    <option value="{{$category->id or ""}}"
            {{--если существует id - это редактирование новости--}}
            @isset($article->id)
                {{--перебираем список категорий--}}
                @foreach ($article->categories as $category_article)
                    @if ($category->id == $category_article->id)
                        selected="selected"
                    @endif
                @endforeach
            @endisset
    >
        {{--{!! для сохранения html разметки!!}--}}
        {!! $delimiter or "" !!}{{$category->title or ""}}
    </option>

    {{--Вывод бесконечной вложенности категорий--}}
    {{--обращаемся к методу children, который создавали в модели--}}

    @if (count($category->children) > 0)
        {{--если есть хоть одна вложенная категория, делаем рекурсию--}}
        @include('admin.articles.partials.categories', [
              'categories' => $category->children,
              'delimiter'  => ' - ' . $delimiter
            ])
    @endif
@endforeach