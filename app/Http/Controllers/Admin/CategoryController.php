<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //отвечает за отображение списка категорий
        //вернуть вид по пути admin/categories/index.php
        // в параметрах указываем переменную, которую передаем
        // выбираем ее из модели методом paginate(10 категорий на странице)
        return view('admin.categories.index', [
            'categories' => Category::paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //отвечает за открытие формы "Создание категории"
        return view('admin.categories.create', [
            'category' => [],
            //колекция категорий (с вложенными)
            // with('children') - указывает метод в модели Категория
            // where - получаем только те категории, которые являются родителями
            'categories' => Category::with('children')->where('parent_id', '0')->get(),
            // символ, обозначающий вложенность
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
        //отвечает за создание записи в таблице
        //Пишем модель и метод для массового заполнения (здесь использовать create лучше чем save - почему?)
        //в create передаем значение фасада $request со значениями нашей формы
        Category::create($request->all());

        //возвращаем именованный маршрут со списком категорий
        return redirect()->route('admin.category.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //для отображения определенной категории
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //отвечает за открытие формы обновления
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Category $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //отвечает за обновление
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //для удаления
    }
}
