<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\ComplaintTypeController;
use Illuminate\Support\Facades\Route;

// Route Autentikasi
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login')->middleware('throttle:10,1');

// Route Publik Fitur Keluhan (React User & Admin)
Route::get('/complaint-types', [ComplaintTypeController::class, 'index']);
Route::get('/complaints', [ComplaintController::class, 'index']);
Route::post('/complaints', [ComplaintController::class, 'store']);
Route::delete('/complaints/{id}', [ComplaintController::class, 'destroy']); // dipindah ke sini

// Route yang butuh token
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/categories', [CategoryController::class, 'index']);
});

Route::apiResource('products', ProductController::class);