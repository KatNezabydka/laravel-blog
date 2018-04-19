<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


//Для отображения категорий и новостей
Route::get('blog/category/{slug?}', 'BlogController@category')->name('category');
Route::get('blog/article/{slug?}', 'BlogController@article')->name('article');

//ADMIN, в скобках пишем параметры для всей группы маршрутов
//Route фасад
Route::group(['prefix' => 'admin', 'namespace' =>'Admin', 'middleware' => ['auth']], function(){
    Route::get('/', 'DashboardController@dashboard')->name('admin.index');
    //Для роутов категории выбираем роут ресурсный...так как контроллер тоже типа ресурс
    //добавили массив, в котором для именованного маршрута добавим префикс, чтобы не переплетался с другими ресурсами
    //['as' =>'admin'] === name('admin')
    Route::resource('/category', 'CategoryController', ['as' =>'admin']);
    Route::resource('/article', 'ArticleController', ['as' =>'admin']);
    //т.к. namespase отличаются и мы добавим еще управление ролями, делаем группу
    //т.к это вложенный маршрут он уже то префикс и namespace дополняются от admin
    Route::group([ 'prefix' => 'user_management', 'namespace' => 'Usermanagement' ], function (){
    //['as' => 'admin.user_management'] - префикс для именованного маршрута
        Route::resource('/user', 'UserController', ['as' => 'admin.user_management']);
    });

});


Route::get('/', function () {
    return view('blog.home');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
