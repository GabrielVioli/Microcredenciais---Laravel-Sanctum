<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CourseController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

#ROTAS AUTENTICADAS
Route::middleware('auth:sanctum')->group(function() {
    Route::post('/credentials', [UserController::class, 'credentials']);
    Route::get('/students/{id}', [StudentController::class, 'show']);
    route::post('/student', [StudentController::class, 'store']);
    Route::put('/students/{id}', [StudentController::class, 'update']);
    Route::get('/courses', [CourseController::class, 'index']);
    Route::get('/courses/{id}', [CourseController::class, 'show']);

    Route::get('/courses/{id}/students', [CourseController::class, 'Credentials']);

});


#ROTAS PUBLICAS
Route::post('/cadastro', [UserController::class, 'store'])->name('cadastro');
Route::post('/login', [UserController::class, 'login'])->name('login');
Route::get('/verify-badge/{hash}', [UserController::class, 'verifyBadge'])->name('verify-badge');

