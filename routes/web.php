<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Авторизация и регистрация
Auth::routes(['verify' => true]);

//Главная страница
Route::get('/', [HomeController::class, 'index'])->name('home');

//Профиль verified
Route::get('/profile', [ProfileController::class, 'showProfileview'])->middleware(['auth', 'verified'])->name('profile');

//CRUD
Route::prefix('crud')->group(function () {

    //Продукты
    Route::get('product/show/{id}', [ProductController::class, 'show'])->name('product.show');

    Route::middleware(['auth', 'verified'])->as('product.')->group(function () {
        //Редактирование
        Route::get('product/edit/{product}', [ProductController::class, 'edit'])->name('edit');
        Route::put('product/update/{product}', [ProductController::class, 'update'])->name('update');
        //Создание
        Route::get('product/create', [ProductController::class, 'create'])->name('create');
        Route::post('product/store', [ProductController::class, 'store'])->name('store');
        //Удаление
        Route::delete('product/destroy/{product}', [ProductController::class, 'destroy'])->name('destroy');
        //Статусы
        Route::get('product/sold/{product}', [ProductController::class, 'soldProduct'])->name('sold');
        Route::get('product/forsale/{product}', [ProductController::class, 'forSaleProduct'])->name('forsale');
        Route::get('product/close/{product}', [ProductController::class, 'closeProduct'])->name('close');
        //Изображения
        Route::get('product/edit/image/{product}', [ProductController::class, 'showImageForm'])->name('edit.image');
        Route::delete('product/destroy/image/{image}', [ProductController::class, 'imageDestroy'])->name('image.destroy');
    });

    //Пользователи
    Route::middleware(['auth', 'verified'])->as('user.')->group(function () {
        //Изменение
        Route::get('user/edit/{user}', [UserController::class, 'edit'])->name('edit');
        Route::post('user/update/{user}', [UserController::class, 'update'])->name('update');
    });

    //Комментарии
    Route::middleware(['auth', 'verified'])->as('review.')->group(function () {
        //Создание
        Route::get('review/create/{id}', [ReviewController::class, 'create'])->name('create');
        Route::post('review/store', [ReviewController::class, 'store'])->name('store');
    });
});

