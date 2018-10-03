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

        $role= factory(App\Role::class, 'test')->create();

        $room1 = factory(App\Room::class, 'test1')->create();
        $room2 = factory(App\Room::class, 'test2')->create();

        factory(App\User::class, 'main', 1)->create()->each(function ($user) use($role, $room1, $room2){
            //записываем в бд роли юзерам через связь users() - многие ко многим
            $role->users()->attach($user);
            //записываем в бд роли юзерам через связь users() - многие ко многим
            $room1->users()->attach($user);
            $room2->users()->attach($user);
            //то есть вызываем фабрику для генерации ФИО и РОЛЕЙ
            //save(factory(App\UserAdditional::class, 'admin') - сохраняем в связной модели и в скобках вызываем генерацию ФИО
            $user->user_additional()->save(factory(App\UserAdditional::class, 'main')->make());
            // выносим это поле, чтобы 5 ролей не создавать
            //$user->roles()->save(factory(App\Role::class, 'admin')->make());
        });

        //чтобы пользователем была присвоена роль администратора, нужно передать параметр role
        //each() - для вложенных отношений
        //factory(App\User::class, 'admin', 1) - вызываем фабрику с имнем admin, 1 - количество циклов
         factory(App\User::class, 'test', 5)->create()->each(function ($user) use($role, $room1){
             //записываем в бд роли юзерам через связь users() - многие ко многим
             $role->users()->attach($user);
             $room1->users()->attach($user);
             //то есть вызываем фабрику для генерации ФИО и РОЛЕЙ
             //save(factory(App\UserAdditional::class, 'admin') - сохраняем в связной модели и в скобках вызываем генерацию ФИО
            $user->user_additional()->save(factory(App\UserAdditional::class, 'test')->make());
            // выносим это поле, чтобы 5 ролей не создавать
            //$user->roles()->save(factory(App\Role::class, 'admin')->make());
        });

    }
}
