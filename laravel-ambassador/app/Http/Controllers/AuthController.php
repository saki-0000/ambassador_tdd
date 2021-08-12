<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateInfoRequest;
use App\Http\Requests\UpdatePasswordRequest;
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
        $token = auth()->user()->createToken('token', ['admin'])->plainTextToken;

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

    /**
     * 与えられた情報をもとにユーザー情報を更新します。
     *
     * @param RegisterRequest $request
     * @return void
     */
    public function updateInfo(UpdateInfoRequest $request)
    {
        $user = $request->user();
        $user->update($request->only('first_name', 'last_name', 'email'));

        return $user;
    }

    /**
     * 与えられた情報をもとにパスワードを更新します。
     *
     * @param RegisterRequest $request
     * @return void
     */
    public function updatePassword(UpdatePasswordRequest $request)
    {
        $user = $request->user();
        $user->update(['password' => Hash::make($request->password)]);

        return $user;
    }
}
