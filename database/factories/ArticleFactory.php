<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

//$factory->define(App\Article::class, function (Faker $faker) {
//    return [
//        'title' => $faker->word,
//        'slug' => $faker->unique()->iso8601($max = 'now'),
//        'description_short' => $faker->sentence($nbWords = 6, $variableNbWords = true),
//        'description' => $faker->paragraph,
//        'meta_title' => $faker->sentence($nbWords = 3, $variableNbWords = true),
//        'meta_description' => $faker->sentence($nbWords = 3, $variableNbWords = true),
//        'meta_keyword' => $faker->sentence($nbWords = 3, $variableNbWords = true),
//         'published' => $faker->boolean,
//
//    ];
//});


$factory->defineAs(App\Article::class,'test1', function (Faker $faker) {
    return [
        'title' => $faker->unique()->word,
        'slug' => $faker->unique(),
        'description_short' => $faker->sentence($nbWords = 6, $variableNbWords = true),
        'description' => $faker->paragraph,
        'meta_title' => $faker->sentence($nbWords = 3, $variableNbWords = true),
        'meta_description' => $faker->sentence($nbWords = 3, $variableNbWords = true),
        'meta_keyword' => $faker->sentence($nbWords = 3, $variableNbWords = true),
        'published' => '1',
        'created_by' => '1'

    ];
});

$factory->defineAs(App\Article::class,'test2', function (Faker $faker) {
    return [
        'title' => $faker->unique()->word,
        'slug' => $faker->unique(),
        'description_short' => $faker->sentence($nbWords = 6, $variableNbWords = true),
        'description' => $faker->paragraph,
        'meta_title' => $faker->sentence($nbWords = 3, $variableNbWords = true),
        'meta_description' => $faker->sentence($nbWords = 3, $variableNbWords = true),
        'meta_keyword' => $faker->sentence($nbWords = 3, $variableNbWords = true),
        'published' => '1',
        'created_by' => '2'

    ];
});

$factory->defineAs(App\Article::class,'test3', function (Faker $faker) {
    return [
        'title' => $faker->unique()->word,
        'slug' => $faker->unique(),
        'description_short' => $faker->sentence($nbWords = 6, $variableNbWords = true),
        'description' => $faker->paragraph,
        'meta_title' => $faker->sentence($nbWords = 3, $variableNbWords = true),
        'meta_description' => $faker->sentence($nbWords = 3, $variableNbWords = true),
        'meta_keyword' => $faker->sentence($nbWords = 3, $variableNbWords = true),
        'published' => '1',
        'created_by' => '3'

    ];
});

//таблица categories заполняем
$factory->defineAs(App\Category::class, 'test1', function(Faker $faker) {
    return [
        'title' => 'Категория-1',
        'slug' => 'pervaya-3004180939',
        'parent_id' => '0',
        'published' => '1',
    ];
});

//таблица categories заполняем
$factory->defineAs(App\Category::class, 'test2', function(Faker $faker) {
    return [
        'title' => 'Категория-2',
        'slug' => 'vtoraya-3004180939',
        'parent_id' => '0',
        'published' => '1',
    ];
});

//таблица categories заполняем
$factory->defineAs(App\Category::class, 'test3', function(Faker $faker) {
    return [
        'title' => 'Категория-3',
        'slug' => 'tretaya-3004180939',
        'parent_id' => '0',
        'published' => '1',
    ];
});