<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Notifications\NotificationEmail;
use App\Notifications\NotificationAuthEmail;

class RegisterController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }
    public function checkRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
        $token = Str::random(20);
        // dd($token);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'token' => $token,
        ]);
        // dd($user);
        $url = url('/email/verify/' . $user->id . '/' . $token);

        $user->notify(new NotificationAuthEMail($user, $url));

        return view('auth.alert');
        // return redirect()->route('resend.email')->with('user', $user->id);
    }

    public function verificationEmail($id, $token)
    {
        $user = User::find($id);
        // dd($user->token);
        // khi xác nhận phải ddoooir mã token không cho phép ng dùng xác nhận nữa
        if ($user && $user->token === $token) {
            $user->token = null;
            $user->save();
            return redirect()->route('login.user', compact('user'))->with('ok', 'Xác nhận tài khoản thành công, bạn có thể đăng nhập');
        } else {
            // nếu trong trường hợp ng dùng mà xác nhận lần nữa trng trường hợp mã token bị thay đổi hoặc hết hạn mã
            $user->find($id)->delete();
            return redirect()->route('register.user')->with('no', 'Mã xác nhận gửi không hợp lệ. Vui lòng đăng ký lại');
        }
    }
}
