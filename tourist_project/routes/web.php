<?php

use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\HomeController;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BookingTourController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FilterController;
use App\Http\Controllers\ManagerInformationPersonnal;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SearchTourController;
use App\Http\Controllers\ShowDestinationController;
use App\Http\Controllers\ShowPostController;
use App\Http\Controllers\ShowTourController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\DialogflowController;
use App\Http\Controllers\FavoriteController;


Route::get('/trang-chu', function () {
    return view('home.home');
});


Route::get('/trang-chu', [HomeController::class, 'index'])->name('home');


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

// Tài khoản khách hàng
Route::get('/quan-ly-tour-ca-nhan', [ManagerInformationPersonnal::class, 'showManager'])->name('manager.tour');
Route::get('/xoa-tour/{orderId}', [ManagerInformationPersonnal::class, 'deletePersonalTour'])->name('delete.tour');
// trang thông tin các nhân
Route::get('/profile/{id}', [ManagerInformationPersonnal::class, 'showProfile'])->name('personal.profile');


// list destination, post follow category
Route::get('/danh-muc/{id}/{slug}', [CategoryController::class, 'listAllFollowCategory'])->name('category.header');
// Xem tất cả địa điểm
Route::get('/dia-diem', [ShowDestinationController::class, 'listAllDestination'])->name('destination.list');
// show detail destination
Route::get('/chi-tiet-dia-diem/{id}/{slug}', [ShowDestinationController::class, 'showDetailDestination'])->name('destination.detail');
// list tour
Route::get('/tour', [ShowTourController::class, 'listAllTour'])->name('tour.list');
// FavoriteTour
Route::get('/tour-yeu-thich/{tourId}', [FavoriteController::class, 'favoriteAdd'])->name('favorite.add');
// list favorite tour
Route::get('/danh-sach-yeu-thich', [FavoriteController::class, 'listFavorite'])->name('favorite.tour');
Route::get('/xoa/tour/{tourId}', [FavoriteController::class, 'deleteFavorite'])->name('favorite.delete');
// show detail tour
Route::get('/chi-tiet-tour/{id}/{slug}', [ShowTourController::class, 'showDetailTour'])->name('tour.detail');

//Bài viết
Route::get('/bai-viet', [ShowPostController::class, 'listPost'])->name('post.list');
Route::get('/bai-viet/{id}/{slug}', [ShowPostController::class, 'postDetail'])->name('post.detail');
// Bình luận
Route::post('/binh-luan', [CommentController::class, 'commentPost'])->middleware('auth')->name('comment.post');
// tìm kiếm tour
Route::get('/tim-kiem', [SearchTourController::class, 'searchTour'])->name('search.tour');
Route::get('/ket-qua-tim-kiem', [SearchTourController::class, 'searchLocation'])->name('search.location');
// TÌm kiếm Ajax
Route::get('/tim-kiem-diem-di', [SearchTourController::class, 'searchAjaxDeparture'])->name('search-departure.ajax');
Route::get('/tim-kiem-diem-den', [SearchTourController::class, 'searchAjaxDestination'])->name('search-destination.ajax');
Route::get('/tim-kiem-dia-diem', [SearchTourController::class, 'searchAjaxLocation'])->name('search-location.ajax');

// Lọc tour
Route::get('/loc-tour', [FilterController::class, 'filterTour'])->name('filter.tour');
// lọc dd
Route::get('/loc-dia-diem', [FilterController::class, 'filterDestination'])->name('filter.destination');

// đặt tour
Route::get('/dat-tour/{id}/{slug}', [BookingTourController::class, 'formBookingTour'])->middleware('auth')->name('booking.form');
Route::post('/dat-tour/{id}', [BookingTourController::class, 'bookingTour'])->middleware('limit')->name('booking.tour');
// Thanh toan tiền còn lại sau khi đã đặt cọc
Route::get('/tiep-tuc-thanh-toan/{orderId}', [BookingTourController::class, 'paymentDeposit'])->name('payment.view');
Route::post('/thanh-toan-dat-coc/vnpay/{orderId}', [PaymentController::class, 'createDepositPayment'])->name('payment.deposit');
Route::get('deposit/vnpay/return/{orderId}', [PaymentController::class, 'depositVnpayReturn'])->name('deposit.return');


// Cổng thanh toán
Route::post('/phuong-thuc-thanh-toan', [PaymentController::class, 'methodPayment'])->name('method.payment');
// Route::post('/thanh-toan-online', [PaymentController::class, 'createPayment'])->name('payment.tour');
Route::get('/vnpay/return', [PaymentController::class, 'vnpayReturn'])->name('vnpay.return');
Route::get('/momo/return', [PaymentController::class, 'momoReturn'])->name('momo.return');
// Route::get('/dialogflow/intents', [DialogflowController::class, 'listIntents']);
Route::post('/chatbot/webhook', [DialogflowController::class, 'handleWebhook']);


require base_path('routes/api.php');
