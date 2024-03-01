<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::group(['prefix' => 'v1' ], function () { 
//     Route::post( 'register' , [ AuthController::class , 'register' ]); 
//     Route::post( 'login' , [ AuthController::class , 'login' ]); 

//     // Route::middleware('auth:api')->group( function(){
//         Route::post('logout', [AuthController::class, 'logout']);

//         Route::post('products', [ProductController::class, 'store']);
//         Route::put('products/{product}', [ProductController::class, 'update']);
//         Route::delete('products/{product}', [ProductController::class, 'destroy']);
//         Route::get('products', [ProductController::class, 'index']);
//         Route::get('products', [ProductController::class, 'show']);


//         Route::post('transactions', [TransactionController::class, 'store']);
//         Route::get('transactions', [TransactionController::class, 'index']);
//         Route::get('transactions/{transaction}', [TransactionController::class, 'show']);
//         Route::put('transactions/{transaction}', [TransactionController::class, 'update']);
//         Route::delete('transactions/{transaction}', [TransactionController::class, 'destroy']);
//     // });

// });
