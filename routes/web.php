<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
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
Route::prefix('crud')->as('product.')->group(function () {
    //Продукты
    Route::get('product/show/{id}', [ProductController::class, 'show'])->name('show');
    Route::middleware(['auth', 'verified'])->group(function () {
        //Редактирование
        Route::get('product/edit/{product}', [ProductController::class, 'edit'])->name('edit');
        Route::put('product/update/{product}', [ProductController::class, 'update'])->name('update');
        //Создание
        Route::get('product/create', [ProductController::class, 'create'])->name('create');
        Route::post('product/store', [ProductController::class, 'store'])->name('store');
        //Удаление
        Route::delete('product/destroy/{product}', [ProductController::class, 'destroy'])->name('destroy');
        //Изображения
        Route::get('product/edit/image/{product}', [ProductController::class, 'showImageForm'])->name('edit.image');
        Route::delete('product/destroy/image/{image}', [ProductController::class, 'imageDestroy'])->name('image.destroy');
    });
});

