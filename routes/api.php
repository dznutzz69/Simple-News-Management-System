<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\PublicNewsController;
use App\Http\Controllers\CategoryController;


use App\Http\Controllers\StatisticController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
Route::middleware('auth:sanctum')->apiResource('articles', ArticleController::class);
Route::middleware('auth:sanctum')->apiResource('categories', CategoryController::class);
Route::get('/public/news', [PublicNewsController::class, 'index']);
Route::get('/public/news/{article}', [PublicNewsController::class, 'show']);
Route::middleware('auth:sanctum')->patch('/articles/{article}/publish', [ArticleController::class, 'publish']);

Route::get('/statistics', [StatisticController::class, 'index']);
