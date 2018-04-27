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

$factory->define(App\Category::class, function (Faker $faker) {
    return [
        'title' => $faker->title,
        'published' => $faker->boolean,
        'parent_id' => 0,
        'created_by' => Carbon\Carbon::now(),
        'modified_by' =>Carbon\Carbon::now(),
    ];
});
