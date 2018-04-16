<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    //так как используем метод create а не save необходимо указать список с разрешенными полями
    //аналог Белого Списка

    protected $fillable = ['title', 'slug', 'parent_id', 'published', 'created_by', 'modified_by'];


    //поле slug - в нем автоматически формируется уникальное значение из title
    //для этого используем преобразователь
    // Mutators - для преобразования полей перед их записью в бд
    public function setSlugAttribute($value) {
        // Str::slug - хелпер, переводит текст с разделителем...$slug = str_slug('Laravel 5 Framework', '-');// laravel-5-framework
        // \Carbon\Carbon::now() - генерируем текущее время
        $this->attributes['slug'] = Str::slug( mb_substr($this->title, 0, 40) . "-" . \Carbon\Carbon::now()->format('dmyHi'), '-');
    }

    //Get children category
    public function children() {
        //self::class - имя текущей модели
        return $this->hasMany(self::class, 'parent_id');
    }
}
