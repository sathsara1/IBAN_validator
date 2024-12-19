<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\IbanController;
use App\Http\Controllers\UploadController;
use App\Http\Middleware\CheckAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);


Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/user', [AuthController::class, 'getCurrentUser']);
    Route::post('/verify', [IbanController::class, 'store']);
    Route::get('/uploads', [UploadController::class, 'index']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::get('/ibans', [IbanController::class, 'index']);
});
