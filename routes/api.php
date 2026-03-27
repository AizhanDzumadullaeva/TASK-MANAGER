<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CategoryController;

Route::post('/register', [AuthController::class,'register']);
Route::post('/login', [AuthController::class,'login']);

Route::get('/categories', [CategoryController::class,'index']);
Route::post('/categories',[CategoryController::class,'store']);

Route::middleware('auth:sanctum')->group(function () {
Route::get('/tasks', [TaskController::class, 'index']);
Route::post('/tasks', [TaskController::class,'store']);
Route::put('/tasks/{id}', [TaskController::class,'update']);
Route::delete('/tasks/{id}', [TaskController::class,'destroy']);
});
