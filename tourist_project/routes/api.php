<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


Route::get('/auth/google/redirect', function () {
    return Socialite::driver('google')->redirect();
});

Route::get('/auth/google/callback', function () {

    $socialiteUser = Socialite::driver('google')->user();
    // dd($socialiteUser);
    $userData = [
        'name' => $socialiteUser->name,
        'email' => $socialiteUser->email,
        'token' => $socialiteUser->token
    ];
    $user = User::updateOrCreate(
        ['email' => $socialiteUser->getEmail()],
        $userData
    );
    Auth::login($user);
    return redirect('dashboard')->with('ok', 'Bạn đã đăng nhập thành công');
});
