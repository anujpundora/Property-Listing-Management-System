<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PropertyController;

Route::apiResource('properties', PropertyController::class);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('properties', PropertyController::class);
});
Route::middleware('auth:sanctum')->group(function () {

    Route::post('/favorites/{property_id}', [FavoriteController::class, 'store']);
    Route::get('/favorites', [FavoriteController::class, 'index']);
    Route::delete('/favorites/{property_id}', [FavoriteController::class, 'destroy']);

});
// Route::get('/properties', [PropertyController::class, 'index']);
// Route::post('/properties', [PropertyController::class, 'store']);