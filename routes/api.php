<?php

use App\Http\Controllers\ProductApiController;
use App\Http\Controllers\PhotoApiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiAuthController;


Route::prefix('v1')->group(function (){

    Route::post('/register',[ApiAuthController::class,"register"])->name("api.register");

    Route::post('/login',[ApiAuthController::class,"login"])->name("api.login");

    Route::middleware(["auth:sanctum"])->group(function(){

        Route::post('/logout',[ApiAuthController::class,"logout"])->name("api.logout");

        Route::post('/logout-all',[ApiAuthController::class,"logoutAll"])->name("api.logoutAll");

        Route::get("/tokens",[ApiAuthController::class,"tokens"])->name("api.tokens");

        Route::apiResource('products', ProductApiController::class);

        Route::apiResource('photos', PhotoApiController::class);

    });

});



//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');
//
//Route::get('/me',function (){
//    return "Phyo Thu Kha";
//});
