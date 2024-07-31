<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Notifications\NotificationEmail;
use Illuminate\Http\Request;


class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(RegisterRequest $request)
    {
        // dd($request->all());

        $token = Str::random(20);
        // dd($token);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'token' => $token,
        ]);

        $url = url('/email/verify/' . $user->id . '/' . $token);
        // dd($url);

        // $user->notify(new NotificationEmail($user, $url));

        return redirect()->route('resend.email')->with('user', $user->id);
    }

    public function showFormResendEmail()
    {
        return view('auth.resend-email');
    }


    public function verificationEmail($id, $token)
    {
        $user = User::find($id);
        // dd($token);
        if ($user && $user->token === $token) {
            $user->token = null;
            $user->save();
            return redirect()->route('login')->with('ok', 'Xác nhận tài khoản thành công, bạn có thể đăng nhập');
        } else {
            return redirect()->route('login')->with('no', 'Mã xác nhận gửi không hợp lệ');
        }
    }

    public function resendEmail(Request $request)
    {
        $user = User::find($request->input('userId'));
        $url = url('/email/verify/' . $user->id . '/' . $user->token);

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('dashboard');
        }
        // Gửi lại email xác minh cho người dùng
        // $user->notify(new NotificationEmail($user, $url));
        // Chuyển hướng người dùng về trang xác nhận email với thông báo
        return back()->with('status', 'Email đã được gửi, vui lòng kiểm tra email!');
    }
}
