<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ApiKeyController;


// Generate API key (public - requires email/password)
Route::post('/keys/generate', [ApiKeyController::class, 'generate']);

Route::middleware(['api.key', 'throttle:api'])->group(function () {

    // API Key management
    Route::get('/keys', [ApiKeyController::class, 'index']);
    Route::delete('/keys/{id}', [ApiKeyController::class, 'revoke']);

    // Product routes
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{id}', [ProductController::class, 'show']);
    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{id}', [ProductController::class, 'update']);
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);
});


Route::get('/test', function () {
    return response()->json(['message' => 'API is working!']);
});
