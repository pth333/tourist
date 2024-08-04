<?php

use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\Auth\RegisterController;


// Login
Route::get('/dang-nhap', [LoginController::class, 'showLogin'])->name('login.user');
Route::post('/dang-nhap', [LoginController::class, 'checkLogin'])->name('login.post');
Route::post('/dang-xuat', [LoginController::class, 'logout'])->name('logout');
//Quên mkhau
Route::get('/quyen-mat-khau', [ForgotPasswordController::class, 'showForgotPassword'])->name('forgot.password');
Route::post('/quyen-mat-khau', [ForgotPasswordController::class, 'submitForgotPassword'])->name('forgot.password.post');
Route::get('/lay-lai-mat-khau/{token}', [ForgotPasswordController::class, 'showResetPassword'])->name('password.show');
Route::post('/lay-lai-mat-khau', [ForgotPasswordController::class, 'submitResetPassword'])->name('password.update');

Route::get('/doi-mat-khau', [ChangePasswordController::class, 'formChangePassword'])->name('password.change');
Route::post('/doi-mat-khau', [ChangePasswordController::class, 'updatePassword'])->name('password.change.post');

// register
Route::get('/dang-ky', [RegisterController::class, 'showRegister'])->name('register.user');
Route::post('/dang-ky', [RegisterController::class, 'checkRegister'])->name('register.post');
Route::get('/email/verify/{id}/{token}', [RegisterController::class, 'verificationEmail'])->name('verify.email');

