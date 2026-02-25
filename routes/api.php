<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\PublicNewsController;



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
Route::middleware('auth:sanctum')->apiResource('articles', ArticleController::class);
Route::middleware('auth:sanctum')->apiResource('categories', CategoryController::class);'categories', CategoryController::class);
Route::get('/public/news', [PublicNewsController::class, 'index']);