<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\ManagerUserController;
use App\Http\Controllers\OrderManagerController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\TourController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});




Route::get('/dashboard', [AdminController::class, 'index'])->middleware('admin')->name('dashboard');

// Category
Route::prefix('/categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('categories.index')->middleware('can:category_list');
    Route::post('/store', [CategoryController::class, 'store'])->name('categories.store')->middleware('can:category_add');
    Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('categories.edit')->middleware('can:category_edit');
    Route::put('/update', [CategoryController::class, 'update'])->name('categories.update');
    Route::get('/delete/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy')->middleware('can:category_delete');
});


// Tour
Route::prefix('/tour')->group(function () {
    Route::get('/', [TourController::class, 'index'])->name('tour.index')->middleware('can:tour_list');
    Route::post('/store', [TourController::class, 'store'])->name('tour.store')->middleware('can:tour_add');
    Route::get('/edit/{id}', [TourController::class, 'edit'])->name('tour.edit')->middleware('can:tour_edit');
    Route::put('/update', [TourController::class, 'update'])->name('tour.update');
    Route::get('/delete/{id}', [TourController::class, 'destroy'])->name('tour.destroy')->middleware('can:tour_delete');

    // Schedule Tour
    Route::get('/schedule', [TourController::class, 'listSchedule'])->name('schedule.tour');
    Route::post('/schedule/store', [TourController::class, 'storeSchedule'])->name('schedule.store');
    Route::get('/schedule/edit/{id}', [TourController::class, 'editSchedule'])->name('schedule.edit');
    Route::put('/schedule/update', [TourController::class, 'updateSchedule'])->name('schedule.update');
    Route::get('/schedule/destroy/{id}', [TourController::class, 'destroySchedule'])->name('schedule.destroy');
});
// POst
Route::prefix('post')->group(function () {
    Route::get('/', [PostController::class, 'index'])->name('post.index');
    Route::post('/store', [PostController::class, 'store'])->name('post.store');
    Route::get('/edit/{id}', [PostController::class, 'edit'])->name('post.edit');
    Route::put('/update', [PostController::class, 'update'])->name('post.update');
    Route::get('/destroy/{id}', [PostController::class, 'delete'])->name('post.delete');
});

Route::prefix('comment')->group(function () {
    Route::get('/', [CommentController::class, 'index'])->name('comment.index');
    Route::get('/delete/{id}', [CommentController::class, 'destroy'])->name('comment.delete');
});

//Slider
Route::prefix('/slider')->group(function () {
    Route::get('/', [SliderController::class, 'index'])->name('slider.index');
    Route::post('/store', [SliderController::class, 'store'])->name('slider.store');
    Route::get('/edit/{id}', [SliderController::class, 'edit'])->name('slider.edit');
    Route::put('/update', [SliderController::class, 'update'])->name('slider.update');
    Route::get('/delete/{id}', [SliderController::class, 'destroy'])->name('slider.destroy');
});

// Destination
Route::prefix('/destination')->group(function () {
    Route::get('/', [DestinationController::class, 'index'])->name('destination.index')->middleware('can:destination_list');
    Route::post('/store', [DestinationController::class, 'store'])->name('destination.store')->middleware('can:destination_add');
    Route::get('/edit/{id}', [DestinationController::class, 'edit'])->name('destination.edit')->middleware('can:destination_edit');
    Route::put('/update', [DestinationController::class, 'update'])->name('destination.update');
    Route::get('/delete/{id}', [DestinationController::class, 'destroy'])->name('destination.destroy')->middleware('can:destination_delete');
});

// Setting
Route::prefix('/setting')->group(function () {
    Route::get('/', [SettingController::class, 'index'])->name('setting.index');
    Route::post('/store', [SettingController::class, 'store'])->name('setting.store');
    Route::get('/edit/{id}', [SettingController::class, 'edit'])->name('setting.edit');
    Route::put('/update', [SettingController::class, 'update'])->name('setting.update');
    Route::get('/delete/{id}', [SettingController::class, 'destroy'])->name('setting.destroy');
});

// user
Route::prefix('/user')->group(function () {
    Route::get('/', [ManagerUserController::class, 'index'])->name('user.index')->middleware('can:user_list');
    Route::post('/store', [ManagerUserController::class, 'store'])->name('user.store')->middleware('can:user_add');
    Route::get('/edit/{id}', [ManagerUserController::class, 'edit'])->name('user.edit')->middleware('can:user_edit');
    Route::put('/update', [ManagerUserController::class, 'update'])->name('user.update');
    Route::get('/delete/{id}', [ManagerUserController::class, 'destroy'])->name('user.destroy')->middleware('can:user_delete');
});

//quản lý kh
Route::prefix('customer')->group(function () {
    Route::get('/transaction', [TransactionController::class, 'listTransactionTour'])->name('transaction.cus');
    Route::post('/transaction/add', [TransactionController::class, 'addTransactionTour'])->name('transaction.cus.add');
    Route::get('/transaction/edit/{id}', [TransactionController::class, 'editTransactionTour'])->name('transaction.cus.edit');
    Route::put('/transaction/update', [TransactionController::class, 'updateTransactionTour'])->name('transaction.cus.update');
    Route::get('/transaction/destroy/{id}', [TransactionController::class, 'destroyTransactionTour'])->name('transaction.cus.delete');
});


// Role
Route::prefix('/role')->group(function () {
    Route::get('/', [RoleController::class, 'index'])->name('role.index')->middleware('can:role_list');
    Route::get('/create', [RoleController::class, 'create'])->name('role.create')->middleware('can:role_add');
    Route::post('/store', [RoleController::class, 'store'])->name('role.store');
    Route::get('/edit/{id}', [RoleController::class, 'edit'])->name('role.edit')->middleware('can:role_edit');
    Route::post('/update/{id}', [RoleController::class, 'update'])->name('role.update');
    Route::get('/delete/{id}', [RoleController::class, 'destroy'])->name('role.destroy')->middleware('can:role_delete');
});


Route::prefix('/manager')->group(function () {
    Route::get('/', [ProfileController::class, 'showProfile'])->name('manager.profile');
    Route::post('/update/{id}', [ProfileController::class, 'updateProfile'])->name('personal.update');
});

Route::prefix('/permission')->group(function () {
    Route::get('/create', [PermissionController::class, 'create'])->name('permission.create');
    Route::post('/store', [PermissionController::class, 'store'])->name('permission.store');
});


require __DIR__ . '/auth.php';
require __DIR__ . '/api.php';
