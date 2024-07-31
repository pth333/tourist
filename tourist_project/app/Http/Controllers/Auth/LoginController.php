<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $remember = $request->has('remember_me') ? true : false;

        $user = User::where('email', $credentials['email'])->first();
        if ($user) {
            if (Auth::attempt($credentials, $remember)) {
                return redirect()->route('home')->with('ok', 'Bạn đã đăng nhập thành công!');
            } else {
                return redirect()->back()->with('no', 'Vui lòng nhập lại tài khoản hoặc mật khẩu!');
            }
        } else {
            return redirect()->back()->with('no', 'Tài khoản của bạn không tồn tại');
        }
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('home')->with('ok', 'Bạn đã đăng xuất thành công!');
    }
}
