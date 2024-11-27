<?php

use Illuminate\Http\Request;
use App\Http\Controllers\ProductApiController;
use App\Http\Controllers\PhotoApiController;
use Illuminate\Support\Facades\Route;



Route::apiResource('products', ProductApiController::class);
Route::apiResource('photos', PhotoApiController::class);

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');
//
//Route::get('/me',function (){
//    return "Phyo Thu Kha";
//});
