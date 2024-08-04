<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\VarDumper\Caster\RedisCaster;

class LoginController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function checkLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');
        // $remember = $request->has('remember_me') ? true : false;

        $token = auth('api')->attempt($credentials);
        // dd($token);
        if(!$token){
            return response()->json([
                'error' => 'Không đuqọc phép truy cập'
            ],401);
        }else{
            $cookie = cookie('jwt_token', $token, 60);
            return redirect()->route('home')->cookie($cookie);
        }
    }

    public function logout()
    {
        Auth::logout();
        $cookie = Cookie::forget('jwt_token');
        // dd($cookie);
        return redirect()->route('home')->cookie($cookie);
    }
}
