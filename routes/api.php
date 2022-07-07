<?php

use App\Http\Controllers\Api\AuthResponceController;
use App\Http\Controllers\Api\NotificationResponseController;
use App\Http\Controllers\Api\ProductResponceController;
use App\Http\Controllers\Api\UserResponceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

//Выборка всех продуктов
Route::get('/product', [ProductResponceController::class, 'index'])->name('api.product.index');
//Полная информация о определенном продукте
Route::get('product/{id}', [ProductResponceController::class, 'product'])->name('api.product.needed');

//Вход и регистрация
Route::post('/auth/enter', [AuthResponceController::class, 'enter'])->middleware('guest')->name('api.auth.enter');
Route::post('/auth/register', [AuthResponceController::class, 'register'])->middleware('guest')->name('api.auth.register');

//Выход
Route::post('/auth/logout', [AuthResponceController::class, 'logout'])->name('api.auth.logout');

//Верификация и сброс
Route::post('/auth/verify', [AuthResponceController::class, 'verify'])->name('api.auth.verify');
Route::post('/auth/reset', [AuthResponceController::class, 'reset'])->name('api.auth.reset');

//Вывод пользователей
Route::get('/user', [UserResponceController::class, 'index'])->middleware(['auth:sanctum', 'verified'])->name('api.user.index');

Route::prefix('crud')->group(function(){

    //Продукты
    Route::middleware(['auth:sanctum', 'verified'])->as('api.product.')->group(function (){
        //Создание
        Route::post('product/create', [ProductResponceController::class, 'createProduct'])->name('create');
        //Редактирование
        Route::post('product/edit', [ProductResponceController::class, 'editProduct'])->name('edit');
        //Удаление
        Route::delete('product/delete/{id}', [ProductResponceController::class, 'deleteProduct'])->name('delete');
        //Статусы
        Route::get('product/sold/{id}', [ProductResponceController::class, 'soldProduct'])->name('sold');
        Route::get('product/for_sale/{id}', [ProductResponceController::class, 'forSaleProduct'])->name('forsale');
        Route::get('product/close/{id}', [ProductResponceController::class, 'closeProduct'])->name('close');
        //Изображения
        Route::delete('product/image/delete/{id}', [ProductResponceController::class, 'deleteProductImage'])->name('image.delete');
        //Создание уведомления
        Route::get('product/notify/create/{id}', [NotificationResponseController::class, 'sendAdminNotification'])->name('notify');
        //Удаление уведомления
        Route::post('product/notify/delete/{id}', [NotificationResponseController::class, 'deleteNotify'])->name('notify.delete');
    });

    //Пользователи
    Route::middleware(['auth:sanctum', 'verified'])->as('api.user.')->group(function (){
        Route::post('user/update/{id}', [UserResponceController::class, 'updateUser'])->name('update');
    });
});
