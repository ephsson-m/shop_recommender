<?php

use App\Http\Controllers\api\ItemController;
use App\Http\Controllers\api\ShopController;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\UserLogController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Route::apiResource('/shops', ShopController::class);
Route::apiResource('/items', ItemController::class);
Route::apiResource('/users', UserController::class);
Route::post('/users/{user}/{shop}', [UserController::class, 'buyItem']);
Route::post('/shops',[ShopController::class, 'storeMultipleShops']);
Route::post('/items',[ItemController::class, 'storeMultipleItems']);
