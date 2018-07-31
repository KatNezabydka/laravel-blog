<?php

namespace App\Http\Controllers;

use App\Article;
use App\Category;
use App\User;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    //отображение категорий, в скобках параметр который может прийти из get запросса
    //blog/category/{slug?}
    public function category($slug)
    {
        // находим категорию, которая пришла к нам из запроса
        //first()- извлекать первое значение
        $category = Category::where('slug', $slug)->first();
        return view('blog.category', [
            'category' => $category,
            //получаем список опубликованных новостей данной категории используя полиморфную связь
            'articles' => $category->articles()->where('published', 1)->paginate(12),
        ]);
    }

    public function article($slug)
    {
        $article = Article::where('slug', $slug)->first();
//        $comments = $this->getComments();
        $comments = $article->comments->load('user', 'article');

        return view('blog.article', [
            //Передаем новость найденную по slug части
            'article' => $article,
            'comments' => $comments
        ]);
    }

    public function subscribe(Request $request)
    {
        //кто подписывается
        $user_id = $request->user_id;
        //на кого
        $subscribers_id = $request->subscribers_id;
        //Находим пользователя, который делает подписку
        $user = User::where('id', $user_id)->first();

        //Записываем только если такой связи нет
        $relations= $user->subscribers()->where('subscrible_id', $subscribers_id)->where('user_id', $user_id )->get();
        if (empty($relations->toArray())) {
            $user->subscribers()->attach($user, ['subscrible_id' => $subscribers_id, 'user_id' => $user_id]);
        }

        return redirect()->back();
    }

}
