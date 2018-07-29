@foreach ($categories as $category)

    {{--Если у категорий есть вложенные пункты, тогда ...--}}
    @if ($category->children->where('published', 1)->count())
        <li class="dropdown dropdown-item">
            <a href="{{ url("/blog/category/$category->slug")}}"
               role="button" aria-expanded="false">
                {{$category->title}}
            </a>
            <a href="" class="dropdown-toggle"
               data-toggle="dropdown" role="button" aria-expanded="false">
               <span class="caret"></span>
            </a>
            <ul class="dropdown-menu" role="menu">
                {{--для вложенного списка, передаем детей, а не родителя--}}
                @include('layouts.top_menu', ['categories' => $category->children])
            </ul>
    @else
        {{-- Обычные пункты меню без вложений --}}
        <li class="dropdown-item">
            <a href="{{ url("/blog/category/$category->slug")}}">
                {{$category->title}}
            </a>
        @endif
        </li>
        @endforeach