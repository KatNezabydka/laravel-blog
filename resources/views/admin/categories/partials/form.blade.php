<label for="">Статус</label>
<select class="form-control" name="published">
    {{--Форма для создания/изменения категорий, поэтому условие--}}
    @if (isset($category->id))
        <option value="0" @if ($category->published == 0) selected="" @endif>Не опубликовано</option>
        <option value="1" @if ($category->published == 1) selected="" @endif>Опубликовано</option>
    @else
        <option value="0">Не опубликовано</option>
        <option value="1">Опубликовано</option>
    @endif
</select>

<label for="">Наименование</label>
{{--value="{{$category->title or ""}}" - blade-helper усли истина выводит иначе то что в кавычках--}}
<input type="text" class="form-control" name="title" placeholder="Заголовок категории" value="{{$category->title or ""}}" required>

<label for="">Slug</label>
<input class="form-control" type="text" name="slug" placeholder="Автоматическая генерация" value="{{$category->slug or ""}}" readonly="">

<label for="">Родительская категория</label>
{{--Отображение красивое в инпуре Родительская категория--}}
<select class="form-control" name="parent_id">
    <option value="0">-- без родительской категории --</option>
    {{--вторым параметром передаем переменную с колекцией родительских элементов--}}
    @include('admin.categories.partials.categories', ['categories' => $categories])
</select>

<hr />

<input class="btn btn-primary" type="submit" value="Сохранить">