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

Route::middleware(['cors', 'auth:api'])
    ->name('user.index')
    ->get('/user', 'API\UserController@index');

Route::middleware(['cors', 'auth:api'])
    ->name('product.index')
    ->get('/product/{offset}/{limit}', 'API\ProductController@index')
    ->where([
        'offset' => '[0-9]+',
        'limit' => '[0-9]+'
    ]);

Route::middleware(['cors', 'auth:api'])
    ->name('product.search')
    ->get('/product/search', 'API\ProductController@search');

Route::middleware(['cors', 'auth:api'])
    ->name('product.create')
    ->post('/product', 'API\ProductController@create');

Route::middleware(['cors', 'auth:api'])
    ->name('product.update')
    ->put('/product/{id}', 'API\ProductController@update')
    ->where([
        'id' => '[0-9]+'
    ]);

Route::middleware(['cors', 'auth:api'])
    ->name('product.destroy')
    ->delete('/product/{id}', 'API\ProductController@destroy')
    ->where([
        'id' => '[0-9]+'
    ]);

Route::middleware(['cors', 'auth:api'])
    ->name('product.destroy.all')
    ->post('/product/destroy-all', 'API\ProductController@destroy_all');

