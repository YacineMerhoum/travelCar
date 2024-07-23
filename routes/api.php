
<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'logout']);
Route::middleware('auth:sanctum')->get('user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('users', [UserController::class, 'index'])->middleware('role:admin');
    Route::get('users/{id}', [UserController::class, 'show'])->middleware('checkUserOrAdmin');
    Route::put('users/{id}', [UserController::class, 'update'])->middleware('checkUserOrAdmin');
    Route::delete('users/{id}', [UserController::class, 'destroy'])->middleware('role:admin');
});

