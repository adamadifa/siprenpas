<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('/presensi', App\Http\Controllers\Api\PresensiController::class);

// AUTH API
Route::prefix('auth')->group(function () {
    Route::post('/login', [App\Http\Controllers\Api\AuthController::class, 'login']);
});

Route::prefix('public')->group(function () {

    //index posts
    Route::get('/posts/getposthomepage', [App\Http\Controllers\Api\PostController::class, 'getposthomepage']);
    Route::get('/posts/getlastposthomepage', [App\Http\Controllers\Api\PostController::class, 'getlastposthomepage']);
    //show posts
    Route::get('/posts/{slug}', [App\Http\Controllers\Api\PostController::class, 'show']);
});
