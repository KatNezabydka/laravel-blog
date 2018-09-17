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
}
