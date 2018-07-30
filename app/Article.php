<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Article extends Model
{
    protected $fillable = ['title', 'slug', 'description_short', 'description', 'image', 'image_show',
        'meta_title', 'meta_description', 'meta_keyword', 'published', 'created_by', 'modified_by'];

    //поле slug - в нем автоматически формируется уникальное значение из title
    //для этого используем преобразователь
    // Mutators - для преобразования полей перед их записью в бд
    public function setSlugAttribute($value)
    {
        // Str::slug - хелпер, переводит текст с разделителем...$slug = str_slug('Laravel 5 Framework', '-');// laravel-5-framework
        // \Carbon\Carbon::now() - генерируем текущее время
        $this->attributes['slug'] = Str::slug(mb_substr($this->title, 0, 40) . "-" . \Carbon\Carbon::now()->format('dmyHi'), '-');
    }


    //Polymorphic relation with categories
    public function categories()
    {
        //morphToMany('App\Category', 'categoryable') - название связной модели и приставка из миграции (categoryable_id)
        return $this->morphToMany('App\Category', 'categoryable');
    }

    //Belongs to
    public function user(){
        return $this->belongsTo('App\User', 'created_by', 'id');
    }
    //Получить подписчиков на статью
    public function user_subscribe(){
        return $this->belongsToMany('App\User');
    }

   //Article и Comment - многие к одному - у одной записи может быть множество комментариев, получаем коментарии, привязанные к записи
    public function comments() {
        return $this->hasMany('App\Comment');
    }

    // Последние N новости
    public function scopeLastArticles($query, $count)
    {
        //возвращаем определенное количество $count
        return $query->orderBy('created_at', 'desc')->take($count)->get();
    }

// Последние N новости конкретного пользователя
    public function scopeLastUserArticles($query, $count, $user_id)
    {
        //возвращаем определенное количество $count
        return $query->orderBy('created_at', 'desc')->where('created_by', $user_id)->take($count)->get();
    }
    //    Все статьи пользователя
    public function scopeUserArticles($query, $user_id)
    {
        return $query->where('created_by', $user_id)->orderBy('created_at', 'desc')->paginate(10);
    }
    //количество статей для конкретного пользователя
    public function scopeCountUserArticles($query, $user_id)
    {
        //возвращаем определенное количество $count
        return $query->where('created_by', $user_id)->count();
    }

//    public function scopePublished($query)
//    {
//        return $query->where('published', 1);
//    }
}
