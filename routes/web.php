<?php

use App\Http\Controllers\HomeController;
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

