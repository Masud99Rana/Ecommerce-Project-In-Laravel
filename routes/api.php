<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::group(['prefix' => 'v1', 'namespace' => 'Api'], function(){
// 	Route::resource('/users', 'UsersController');
// });

Route::group(['namespace' => 'Api', 'prefix' => 'v1'], function () {
    Route::get('/', function () {
        return response()->json([
            'success' => true,
            'message' => 'Welcome to Ecommerce API',
            'data' => [],
        ]);
    });

    Route::get('/cart', 'CartController@getCart');
    Route::post('/cart', 'CartController@addToCart');
    Route::post('/cart/remove', 'CartController@removeFromCart');
    Route::post('/cart/clear', 'CartController@clearCart');
});