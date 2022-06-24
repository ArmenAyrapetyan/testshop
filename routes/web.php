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
Auth::routes();

//Главная страница
Route::get('/', [HomeController::class, 'index'])->name('home');

//Профиль
Route::get('/profile', [ProfileController::class, 'showProfileview'])->middleware('auth')->name('profile');

//CRUD
Route::prefix('crud')->group(function () {
    //Продукты
    Route::get('product/show/{id}', [ProductController::class, 'show'])->name('product.show');
    //Редактирование
    Route::get('product/edit/{product}', [ProductController::class, 'edit'])->middleware('auth')->name('product.edit');
    Route::put('product/update/{product}', [ProductController::class, 'update'])->middleware('auth')->name('product.update');
    //Создание
    Route::get('product/create', [ProductController::class, 'create'])->middleware('auth')->name('product.create');
    Route::post('product/store', [ProductController::class, 'store'])->middleware('auth')->name('product.store');
    //Удаление
    Route::delete('product/destroy/{product}', [ProductController::class, 'destroy'])->middleware('auth')->name('product.destroy');
    //Изображения
    Route::get('product/edit/image/{product}', [ProductController::class, 'showImageForm'])->middleware('auth')->name('product.edit.image');
    Route::delete('product/destroy/image/{image}', [ProductController::class, 'imageDestroy'])->middleware('auth')->name('product.image.destroy');
});

