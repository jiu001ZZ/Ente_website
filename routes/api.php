<?php

use App\Http\Controllers\API\ApiBookmarkController;
use App\Http\Controllers\API\TempatMakanController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/getTempatMakan', [TempatMakanController::class, 'getWarungMakan']);
Route::get('/getRatingWarung/{id}', [TempatMakanController::class, 'getRatingByWarung']);
Route::post('/storeRatingWarung', [TempatMakanController::class, 'storeRatingWarung']);

Route::get('/bookmark', [ApiBookmarkController::class, 'index']);
Route::post('/bookmark', [ApiBookmarkController::class, 'store']);
Route::delete('/bookmark/delete/{id}', [ApiBookmarkController::class, 'deleteData']);
