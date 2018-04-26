<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class BlogServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // добавляем обращение к нашему методу topMenu() чтобы он загрузился
        $this->topMenu();
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    //Top menu for users
    //Создаем отдельную функцию, которую будем загружать
    public function topMenu(){
        // передаем из провайдера в шаблон переменную, вызвав фасад View
        //второй параметр функция с переменной
        View::composer('layouts.header', function($view) {
            //передача в шаблон переменной методом with бепем только родительские категории и опубликованные
            $view->with('categories', \App\Category::where('parent_id',  0)
                ->where('published', 1)->get());

        });
    }
}
