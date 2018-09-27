<?php

namespace App\Http\Controllers;

use App\Events\NewEvent;
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
//               'backgroundColor' => ['#F26202','#D01919', '#E26202', '#B5CC18'],
               'backgroundColor' => '#F26202',
               'data' => [15000, 5000, 10000, 30000]
            ])
        ];
    }
    public function newEvent(Request $request) {
        $result = [
            'labels' => ['март', 'апрель', 'май', 'июнь'],
            'datasets' => array([
                'label' => 'Продажи',
                'backgroundColor' => '#F26202',
                'data' => [15000, 5000, 10000, 30000]
            ])
        ];
        if($request->has('label')) {
            $result['labels'][] = $request->input('label');
            $result['datasets'][0]['data'][] = (integer)$request->input('sale');

            if ($request->has('realtime')) {
                if (filter_var($request->input('realtime'), FILTER_VALIDATE_BOOLEAN)){
                    // вызываем событие, которые создали
                    event(new NewEvent($result));
                }
            }
        }
        return $result;
    }

}
