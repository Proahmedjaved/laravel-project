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



Route::namespace('API')->group(function (){
    Route::post('register','AuthController@register');
    Route::post('login','AuthController@login');

    Route::middleware('auth:api')->prefix('product')->group(function (){
        Route::get('/','ProductController@index');
        Route::post('store','ProductController@store');
        Route::get('show/{product}','ProductController@show');
        Route::patch('update/{product}','ProductController@update');
        Route::delete('delete/{product}','ProductController@destroy');
    });

    Route::middleware('auth:api')->group(function (){
        Route::post('/logout','AuthController@logout');
    });
});

