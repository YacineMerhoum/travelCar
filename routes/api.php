<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TripsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'logout']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Routes pour les voyages
Route::middleware('auth:sanctum')->group(function () {
    Route::post('trips', [TripsController::class, 'store']);
    Route::get('trips', [TripsController::class, 'index']);
    Route::get('trips/{id}', [TripsController::class, 'show']);
    Route::put('trips/{id}', [TripsController::class, 'update']);
    Route::delete('trips/{id}', [TripsController::class, 'destroy']);
});

// Routes pour les utilisateurs
Route::middleware('auth:sanctum')->group(function () {
    Route::get('users', [UserController::class, 'index'])->middleware('can:admin-only');
    Route::get('users/{id}', [UserController::class, 'show'])->middleware('can:view-user,id');
    Route::put('users/{id}', [UserController::class, 'update'])->middleware('can:update-user,id');
    Route::delete('users/{id}', [UserController::class, 'destroy'])->middleware('can:admin-only');
});

