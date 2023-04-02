<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MeController;
use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::post('verify-email', [AuthController::class, 'verifyEmail']);
Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('reset-password', [AuthController::class, 'resetPassword']);
Route::post('verify-forgot-password-token', [AuthController::class, 'verifyForgotPasswordToken']);

Route::prefix('/me')->middleware(['auth:api'])->group(function () {
    Route::get('', [MeController::class, 'index']);
    Route::put('update-profile', [MeController::class, 'updateProfile']);
    Route::put('update-password', [AuthController::class, "updatePassword"]);
});

Route::prefix('/todos')->middleware(['auth:api'])->group(function () {
    Route::get('', [TodoController::class, 'index']);
    Route::get('/{todo}', [TodoController::class, 'show']);
    Route::post('', [TodoController::class, 'store']);
    Route::put('/{todo}', [TodoController::class, 'update']);
    Route::delete('/{todo}', [TodoController::class, 'destroy']);
});
