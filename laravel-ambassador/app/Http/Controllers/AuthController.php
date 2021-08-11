<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
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
            'password' => Hash::make($request->password), 'is_admin' => 1
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

        $cookie = cookie('jwt', $token, 60 * 24);
        return response(['message' => 'success'])->withCookie($cookie);
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
