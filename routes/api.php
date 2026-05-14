<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\HealthController;
use App\Http\Controllers\Api\AuthController;
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
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
