<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ForgotPasswordController;


// Login and Register
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::get('/logout', [AuthenticatedSessionController::class, 'logout'])->name('logout');

Route::get('/forget-password', [ForgotPasswordController::class, 'showForgetPassword'])->name('forget.password.get');
Route::post('/forget-password', [ForgotPasswordController::class, 'submitForgetPassword'])->name('forget.password.post');
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetPassword'])->name('password.reset');
Route::post('/reset-password', [ForgotPasswordController::class, 'submitResetPassword'])->name('password.update');

Route::get('/email/verify/{id}/{token}', [RegisteredUserController::class, 'verificationEmail'])->name('verify.email');
Route::get('/email/verification-notification', [RegisteredUserController::class, 'showFormResendEmail'])->name('resend.email');
Route::post('/email/verification-notification', [RegisteredUserController::class, 'resendEmail']);


