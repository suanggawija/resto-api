<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('/auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
});

Route::middleware('auth:sanctum')->group(function () {
    // Auth -----------------------------------------------------------------
    Route::prefix('/auth')->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::get('/logout', [AuthController::class, 'logout']);
    });

    // Order -----------------------------------------------------------------
    Route::get('/order', [OrderController::class, 'index']);
    Route::get('/order/{id}', [OrderController::class, 'show']);
    // Able Create Order
    Route::middleware('ableCreateOrder')->group(function () {
        Route::post('/order', [OrderController::class, 'store']);
    });

    // Able Finish Order
    Route::middleware('ableFinishOrder')->group(function () {
        Route::get('/order/{id}/set-as-done', [OrderController::class, 'setAsDone']);
    });

    // Able Pay Order
    Route::middleware('ablePayOrder')->group(function () {
        Route::get('/order/{id}/payment', [OrderController::class, 'payment']);
    });

    // Users -----------------------------------------------------------------
    // Able Create User
    Route::middleware(['ableCreateUser'])->group(function () {
        Route::get('/user', [UserController::class, 'index']);
        Route::post('/user', [UserController::class, 'store']);
    });

    // Items -----------------------------------------------------------------
    Route::get('/item', [ItemController::class, 'index']);
    // Able Create Update Items
    Route::middleware(['ableCreateUpdateItems'])->group(function () {
        Route::post('/item', [ItemController::class, 'store']);
        Route::patch('/item/{id}', [ItemController::class, 'update']);
    });
});
