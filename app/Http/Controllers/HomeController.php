<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\NewEvent;
use App\Events\NewMessage;
use App\Events\PrivateMessage;
use App\Events\PrivateChat;
use App\Events\Message;
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

//    public function chartData(){
//        return [
//          'labels' => ['март', 'апрель', 'май', 'июнь'],
//           'datasets' => array([
//               'label' => 'Продажи',
////               'backgroundColor' => ['#F26202','#D01919', '#E26202', '#B5CC18'],
//               'backgroundColor' => '#F26202',
//               'data' => [15000, 5000, 10000, 30000]
//            ])
//        ];
//    }
//    public function newEvent(Request $request) {
//        $result = [
//            'labels' => ['март', 'апрель', 'май', 'июнь'],
//            'datasets' => array([
//                'label' => 'Продажи',
//                'backgroundColor' => '#F26202',
//                'data' => [15000, 5000, 10000, 30000]
//            ])
//        ];
//        if($request->has('label')) {
//            $result['labels'][] = $request->input('label');
//            $result['datasets'][0]['data'][] = (integer)$request->input('sale');
//
//            if ($request->has('realtime')) {
//                if (filter_var($request->input('realtime'), FILTER_VALIDATE_BOOLEAN)){
//                    // вызываем событие, которые создали
//                    event(new NewEvent($result));
//                }
//            }
//        }
//        return $result;
//    }
//
//    public function sendMessage(Request $request)
//    {
//        event(new NewMessage($request->input('message')));
//    }
//
//    public function sendPrivateMessage(Request $request)
//    {
////        event(new PrivateMessage($request->input('message')));
//        //другой метод вызова event
//        PrivateMessage::dispatch($request->all());
//        return $request->all();
//    }
//
//    public function messages(Request $request)
//    {
//        Message::dispatch($request->all());
//    }
//
//    public function privateMessages(Request $request)
//    {
//        PrivateChat::dispatch($request->all());
//    }
//
//    public function room($id, Request $request)
//    {
//        return view('blog.room', ['room' => $id]);
//    }

}
