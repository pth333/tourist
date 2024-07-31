<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Notifications\NotificationResetEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{
    public function showForgotPassword()
    {
        return view('auth.forgot_password');
    }
    public function submitForgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
        ], [
            'email.required' => 'Vui lòng nhập vào trường',
            'email.email' => 'Vui lòng nhập email',
            'email.exists' => 'Email không tồn tại'
        ]);

        $token = Str::random(20);

        $user = User::where('email', $request->email)->first();

        $url =  url('/lay-lai-mat-khau' . '/' . $token);

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        DB::table('password_reset_tokens')->updateOrInsert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now(),
        ]);

        $user->notify(new NotificationResetEmail($user, $url));

        return redirect()->back()->with('status', 'Vui lòng kiểm tra Email');
    }

    public function showResetPassword($token)
    {
        // dd($token);
        return view('auth.reset_password', ['token' => $token]);
    }

    public function submitResetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        $user_token = DB::table('password_reset_tokens')->where('email', $request->email)->first();

        // Kiểm tra tgian hết hạn
        $tokenCreationTime = Carbon::parse($user_token->created_at);
        $tokenExpirationTime = $tokenCreationTime->addMinutes(60);
        $currentTime = Carbon::now();
        if ($currentTime->greaterThan($tokenExpirationTime)) {
            return redirect()->back()->with(['no' => 'Token đã hết hạn. Vui lòng yêu cầu lại.']);
        }

        if ($request->input('token') === $user_token->token) {
            $user->update([
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            // Xóa token sau khi đã đặt lại mkhau
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            return redirect()->route('login.user')->with('ok', 'Bạn đã lấy lại mật khẩu thành công');
        } else {
            return redirect()->route('login.user')->withErrors(['no' => 'Token không hợp lệ.']);
        }
    }
}
