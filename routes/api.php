<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    Route::controller(ProductController::class)->prefix('products')->group(function () {
        Route::get('/', 'show');
        Route::get('/{id}', 'showProduct');
        Route::post('/', 'create');
        Route::patch('/{id}', 'update');
        Route::put('/{id}', 'replace');
        Route::delete('/{id}', 'destroy');
    });

    Route::controller(CategoryController::class)->prefix('categories')->group(function () {
        Route::get('/', 'show');
    });
});
