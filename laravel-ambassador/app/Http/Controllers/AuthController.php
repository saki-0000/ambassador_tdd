<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    /**
     * 必要な情報をもとにユーザーを作成します。
     *
     * @param RegisterRequest $request
     * @return void
     */
    public function register(RegisterRequest $request)
    {
        return User::create($request->only([
            'first_name', 'last_name', 'email'
        ]) + [
            'password' => 'a', 'is_admin' => 1
        ]);
    }
}
