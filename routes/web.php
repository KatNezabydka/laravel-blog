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
//Группа роутов для админки, в скобках пишем параметры для всей группы маршрутов
//Route фасад
Route::group(['prefix' => 'admin', 'namespace' =>'Admin', 'middleware' => ['auth']], function(){
    Route::get('/', 'DashboardController@dashboard')->name('admin.index');
    //Для роутов категории выбираем роут ресурсный...так как контроллер тоже типа ресурс
    //добавили массив, в котором для именованного маршрута добавим префикс, чтобы не переплетался с другими ресурсами
    //['as' =>'admin'] === name('admin')
    Route::resource('/category', 'CategoryController', ['as' =>'admin']);
});

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
