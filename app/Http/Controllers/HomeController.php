<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //check visitor
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::with('categories', 'comments', 'user')->take(10)->get();
        return view('blog.home', ['articles' => $articles]);
    }
    
    public function getArticles(){
        $articles = Article::with('categories', 'comments', 'user')->take(3)->get();
//        return view('blog.home', ['articles' => $articles]);
        return response(['status' => 'success', 'message' => '', 'data' => $articles]);
    }

    public function chartData(){
        return [
          'labels' => ['март', 'апрель', 'май', 'июнь'],
           'datasets' => array([
               'label' => 'Продажи',
               'backgroundColor' => ['#F26202','#D01919', '#E26202', '#B5CC18'],
               'data' => [15000, 50000, 10000, 30000]
            ])
        ];
    }

}
