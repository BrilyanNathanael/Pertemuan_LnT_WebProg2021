<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/articles', 'ArticleController@apiIndex');
Route::post('/articles', 'ArticleController@apiStore');
Route::put('/articles/{id}', 'ArticleController@apiUpdate');
Route::delete('/articles/{id}', 'ArticleController@apiDestroy');