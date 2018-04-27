<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //определяем нашу модель с посевом
      $this->call(UsersTableSeeder::class);
    }
}
