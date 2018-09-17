<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;


class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //информация с полей формы комментарий доступна в переменной request и мы ее сохраняем
        //все поля кроме
        $data = $request->except('_token', 'comment_post_ID','comment_parent');
        $data['article_id'] = $request->input('comment_post_ID');


        $validator = Validator::make($data, [
            'text' => 'string|required|min:2',
            'name' => 'sometimes|required|max:255',
            'email' => 'sometimes|required|max:255|email'

        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        };

        //вернет объект модели аутентифицированного пользователя
        $user = Auth::user();

        // смотрим если пользователь зарегистрирован - передаем его id
        if ($user) {
            $data['user_id'] = $user->id;
            $data['name'] = $user->name;
            $data['email'] = $user->email;

        }

        // передаем переменной все параметры с request для создания новости
        Comment::create($data);

        return redirect()->back();

//        $post = Article::find($data['article_id']);
//        //сохраняем новый коммент в бд
//        $post->comments()->save($comment);
//
//
//
//        //подгрузим информацио о пользователе, если коммент оставил зарегистрированный пользователь
//        $comment->load('user');
//
//        $data['id'] = $comment->id;
//
//        $data['email'] = (!empty($data['email'])) ? $data['email'] : $comment->user->email;
//        $data['name'] = (!empty($data['name'])) ? $data['name'] : $comment->user->name;

//
//        $view_comment = view(config('settings.theme').'.content_one_comment')->with('data', $data)->render();
//
//        return \Response::json(['success' => TRUE, 'comment' => $view_comment, 'data' => $data]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
