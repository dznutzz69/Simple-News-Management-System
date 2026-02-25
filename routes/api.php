<?php

use App\Http\Controllers\CategoryController;

Route::middleware('auth:sanctum')->apiResource('categories', CategoryController::class);'categories', CategoryController::class);
