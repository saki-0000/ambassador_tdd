<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
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

    /**
     * 与えられた情報をもとにログインします。
     *
     * @param RegisterRequest $request
     * @return void
     */
    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response(['invalid credentials'], Response::HTTP_UNAUTHORIZED);
        }
        $token = auth()->user()->createToken('token')->plainTextToken;

        return response(['message' => 'success'])->cookie('jwt', $token, 60 * 24);
    }

    /**
     * 与えられた情報をもとにログインします。
     *
     * @param RegisterRequest $request
     * @return void
     */
    public function user()
    {
        return auth()->user();
    }

    /**
     * ログアウトします。
     *
     * @param RegisterRequest $request
     * @return void
     */
    public function logout()
    {
        Cookie::forget('jwt');
        return;
    }
}
