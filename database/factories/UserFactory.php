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
    static $password;
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->defineAs(App\User::class, 'main', function(Faker $faker) {
    return [
        'name' => 'Kat',
        'email' => 'KatOrif@ukr.net',
        'password' => bcrypt('111111'),
        'remember_token' => str_random(10),
    ];
});

//defineAs - потому что define уже есть
//admin - имя фабрики
$factory->defineAs(App\User::class, 'test', function(Faker $faker) {
    return [
        'name' => 'admin',
        'email' => $faker->unique()->safeEmail,
        'password' => bcrypt('111111'),
        'remember_token' => str_random(10),
    ];
});
//так как заполняем связанные таблицы, нужно их заполнить тоже
//таблица roles заполняем
$factory->defineAs(App\Role::class, 'test', function(Faker $faker) {
    return [
        'name' => 'Администратор',
        'slug' => 'admin',
        'description' => 'Администратор с полными правами',
        'group' => 'администраторы',
    ];
});
//таблицы с нашим ФИО заполняем
$factory->defineAs(App\UserAdditional::class, 'test', function(Faker $faker) {
    // Генерация ФИО на русском, используя фасад Factory
    $faker = \Faker\Factory::create('ru_RU');
    return [
        'lastname' => $faker->lastName,
        'firstname' => $faker->firstName,
        'patronymic' => 'Иванович',

    ];
});

$factory->defineAs(App\UserAdditional::class, 'main', function(Faker $faker) {
    return [
        'lastname' => 'Петрова',
        'firstname' => 'Екатерина',
        'patronymic' => 'Юрьевна',

    ];
});