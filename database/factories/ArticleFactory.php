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

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'title' => $faker->title,
//        'slug' =>
//        'description_short' => $faker->sentence($nbWords = 6, $variableNbWords = true),
//        'description' => $faker->paragraph,
//        'meta_title' => $faker->sentence($nbWords = 3, $variableNbWords = true),
//        'meta_description' => $faker->sentence($nbWords = 3, $variableNbWords = true),
//        'meta_keyword' => $faker->sentence($nbWords = 3, $variableNbWords = true),
//         'published' => $faker->boolean,
//        'created_by' => $faker->firstName,

    ];
});
