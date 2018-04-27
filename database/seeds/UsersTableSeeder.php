<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $role= factory(App\Role::class, 'admin')->create();
        //чтобы пользователем была присвоена роль администратора, нужно передать параметр role
        //each() - для вложенных отношений
        //factory(App\User::class, 'admin', 1) - вызываем фабрику с имнем admin, 1 - количество циклов
         factory(App\User::class, 'admin', 5)->create()->each(function ($user) use($role){
             //записываем в бд роли юзерам через связь users() - многие ко многим
             $role->users()->attach($user);
             //то есть вызываем фабрику для генерации ФИО и РОЛЕЙ
             //save(factory(App\UserAdditional::class, 'admin') - сохраняем в связной модели и в скобках вызываем генерацию ФИО
            $user->user_additional()->save(factory(App\UserAdditional::class, 'admin')->make());
            // выносим это поле, чтобы 5 ролей не создавать
            //$user->roles()->save(factory(App\Role::class, 'admin')->make());
        });
    }
}
