<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Article;
use App\Category;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //Dashboard
    public function dashboard() {
        return view('admin.dashboard', [

            'categories' => Category::lastCategories(5),
//            'articles' => Article::lastArticles(5),
            //получаем новости только текущего пользователя
            'articles' => Article::LastUserArticles(5, Auth::id()),
            'count_categories' => Category::count(),
//            'count_articles' => Article::count()
            'count_articles' => Article::CountUserArticles(Auth::id()),
            //список подписчиков на данного автора
            'subscribers' => Auth::user()->users

        ]);
    }
}
