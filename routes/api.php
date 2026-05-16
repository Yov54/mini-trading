<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\HealthController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MarketController;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Health Check Endpoint
Route::get('/ping', [HealthController::class, 'index']);

// Authentication Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected Routes (require authentication/Can only be accessed with a token)
Route::middleware('auth:sanctum')->group(function () {
    // Routes for viewing user data and balance
    Route::get('/user', function (Request $request) {
        return response()->json([
            'status' => 'success',
            'data' => $request->user()
        ]);
    });

    // Transaction Routes
    Route::post('/trade/buy', [App\Http\Controllers\Api\TransactionController::class, 'buy']);
});

Route::get('/market-prices', [MarketController::class, 'getPrices']);