<?php

use App\Http\Controllers\Api\Account\AccountController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Category\CategoryController;
use App\Http\Controllers\Api\Income\IncomeController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
});

Route::apiResource('accounts', AccountController::class);
Route::apiResource('categories', CategoryController::class);
Route::apiResource('incomes', IncomeController::class);
