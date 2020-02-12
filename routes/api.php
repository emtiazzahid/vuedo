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

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/
Route::group(['namespace' => 'Api'], function () {
    //posts
    Route::post('posts/{posts}/publish', ['as' => 'api.posts.publish', 'uses' => 'PostsController@publish']);
    Route::post('posts/{posts}/image', ['as' => 'api.posts.updateImage', 'uses' => 'PostsController@updateImage']);
    Route::resource('posts', 'PostsController', ['except' => ['create', 'edit']]);

    //categories
    Route::resource('categories', 'CategoriesController', ['except' => ['create', 'edit']]);

    //posts categories
    Route::patch('posts/{posts}/categories', ['as' => 'api.posts.categories.sync', 'uses' => 'PostsCategoriesController@sync']);
    Route::resource('posts.categories', 'PostsCategoriesController', ['only' => ['index', 'store', 'destroy']]);

    //categories posts
    Route::get('categories/{categories}/posts', [ 'as' => 'api.categories.posts.index', 'uses' => 'CategoriesPostsController@index']);

    //users
    Route::get('me', ['as' => 'api.me.show', 'uses' => 'MeController@show']);
    Route::patch('me', ['as' => 'api.me.update', 'uses' => 'MeController@update']);
    Route::put('me', ['as' => 'api.me.update', 'uses' => 'MeController@update']);
});