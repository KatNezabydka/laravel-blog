<?php

namespace App\Http\Controllers\Admin\Usermanagement;

use App\User;
use App\UserAdditional;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        return view('admin.user_management.users.index', [
//        //paginate(10) - выбирает из бд и делает пагинацию
//            'users' => User::paginate(10)
//        ]);
        return view('admin.user_management.users.index', [
            'user' => Auth::user()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user_management.users.create', [
            'user' => []
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // перед сохранением данных делаем дополнительную валидацию полей
        $validator = $request->validate([
            'name' => 'required|string|max:255',
            'lastname' => 'string|max:255',
            'patronymic' => 'string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
        //вызываем метод массового заполнения
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password'])
        ]);
        $user->user_additional()->create([
            'user_id' => $user->id,
            'firstname' => $request['name'],
            'lastname' => $request['lastname'],
            'patronymic' => $request['patronymic']
        ]);


        return redirect()->route('admin.user_management.user.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('admin.user_management.users.edit', [
            'user' =>  $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        // перед обновлением данных делаем дополнительную валидацию полей - т.к. имэйл могут не менять, а оно должно быть уникальное
        //меняем валидацию для email и password который мы тоже можем не запомнить
        $validator = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                \Illuminate\Validation\Rule::unique('users')->ignore($user->id)
            ],
            //nullable вместо required чтобы пропустило если пустой пароль
            'password' => 'nullable|string|min:6|confirmed',
        ]);
        //обновление данных будем делать без массового заполнения
        $user->name = $request['name'];
        $user->email = $request['email'];
        // если пароль не меняли нужно ничего не передавать, иначе передать новое значение
        $request['password'] == null ?: $user->password = bcrypt($request['password']);

        $update_user = $user->save();
//        $update_user->user_additional()->create([
//            'firstname' => $request['name'],
//            'lastname' => $request['lastname'],
//            'patronymic' => $request['patronymic']
//        ]);


        return redirect()->route('admin.user_management.user.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.user_management.user.index');
    }
}
