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

Route::any('/auth', 'AuthController@auth');
Route::group(['middleware' => 'auth:api'], function (){
    Route::get('/user',  function (Request $request){
        return $request->user();
    });
    Route::group(['prefix' => 'posts'], function (){
        Route::get('/',  'PostsController@get');
        Route::post('/add',  'PostsController@add');
        Route::post('/{id}/delete',  'PostsController@delete');
        Route::post('/{id}/edit',  'PostsController@edit');

    });


});