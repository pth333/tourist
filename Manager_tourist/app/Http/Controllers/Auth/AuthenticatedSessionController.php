<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthenticatedSessionController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $credentials = $request->only('email', 'password');

        $remember = $request->has('remember_me') ? true : false;

        $user = User::where('email', $credentials['email'])->first();
        // dd($user);
        if ($user) {
            if (Auth::attempt($credentials, $remember)) {
                return redirect()->route('dashboard')->with('ok', 'Bạn đã đăng nhập thành công!');
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
        return redirect()->route('login')->with('ok', 'Bạn đã đăng xuất thành công!');
    }
}
