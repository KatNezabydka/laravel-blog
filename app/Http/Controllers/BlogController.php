<?php

namespace App\Http\Controllers;

use App\Article;
use App\Category;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    //отображение категорий, в скобках параметр который может прийти из get запросса
    //blog/category/{slug?}
    public function category($slug){
        // находим категорию, которая пришла к нам из запроса
        //first()- извлекать первое значение
        $category = Category::where('slug', $slug)->first();
        return view('blog.category', [
           'category' => $category,
            //получаем список опубликованных новостей данной категории используя полиморфную связь
            'articles' => $category->articles()->where('published', 1)->paginate(12),
        ]);
    }

    public function article($slug){
        return view('blog.article', [
          //Передаем новость найденную по slug части
            'article' => Article::where('slug', $slug)->first(),
        ]);
    }
}
