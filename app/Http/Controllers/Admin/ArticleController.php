<?php

namespace App\Http\Controllers\Admin;

use App\Article;
use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //в параметрах список новостей, сортировать будем в обратном порядке по дате создания
        return view('admin.articles.index', [
            'articles' => Article::orderBy('created_at', 'desc')->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //создание новости
        return view('admin.articles.create', [
            'article' => [],
            'categories' => Category::with('children')->where('parent_id', 0)->get(),
            'delimiter' => ''
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // передаем переменной все параметры с request для создания новости
        $article = Article::create($request->all());

        //Categories - смотрим есть ли значение в поле Категория
        if ($request->input('categories')) :
            //categories() - метод из модели где описана полиморфная связь
            // attach() - присоединяет массив с категориями
            //$request->input('categories') - это id категорий, к которым относится новость
            $article->categories()->attach($request->input('categories'));
        endif;

     return redirect()->route('admin.article.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Article $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Article $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        return view('admin.articles.edit', [
            'article'    => $article,
            'categories' => Category::with('children')->where('parent_id', 0)->get(),
            'delimiter'  => ''
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Article $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        //отвечает за обновление
        //не включаем в обновление поле slug - оно не должно меняться
        $article->update($request->except('slug'));
        //если список редактирования пуст, значит нет привязанных категорий => нужно удалить
        //detach() - уничтожает все записи попадающие под совпадение id новости
        //atach() - а если существует - тогда подключаем наши категории

        $article->categories()->detach();
        if($request->input('categories')) :
            $article->categories()->attach($request->input('categories'));
        endif;


        return redirect()->route('admin.article.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Article $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        //отсоединяем все связи с категориями
        $article->categories()->detach();
        //удаляем экземпляр новости из базы
        $article->delete();

        return redirect()->route('admin.article.index');

    }
}
