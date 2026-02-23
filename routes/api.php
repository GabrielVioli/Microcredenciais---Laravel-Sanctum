<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::middleware('auth:sanctum')->post('/credentials', [UserController::class, 'credentials']);


Route::post('/cadastro', [UserController::class, 'store'])->name('cadastro');
Route::post('/login', [UserController::class, 'login'])->name('login');


Route::get('/verify-badge/{hash}', [UserController::class, 'verifyBadge'])->name('verify-badge');

