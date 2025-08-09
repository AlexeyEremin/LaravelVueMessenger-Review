<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\CreateRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function getMe() {
        # Можно через auth() получить пользователя которым автризованы,
        # главное чтобы это вызывалось внутри middleware > auth а то fatal error
        return auth()->user();
    }

    /**
     * Да вроде этот метод я просил у тебя сделать POST через body
     * @param Request $request ---- Переписать Request на php artisan make:request, валидация
     * @param string $query
     * @return mixed
     */
    public function searchUserByName(Request $request, string $query) {
        # А если пользователей больше 15 то че? Как получить следующих?
        return User::whereLike('name', '%' . $query . '%')->limit(15)->get();
    }

    public function standartUser(CreateRequest $request)
    {
        # Обязательно используй validated метод, он получает только те поля которые в rules Request'а
        $user = User::create($request->validated());
        return response($user, 201);
    }
}
