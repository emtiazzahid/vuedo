<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => 'web'], function () {
    //homepage
    Route::get('/', ['as' => 'web.home', 'uses' => 'PagesController@home']);
    Route::get('blog', ['as' => 'web.blog', 'uses' => 'PagesController@home']);
    Route::get('/blog/{posts}', ['as' => 'web.post', 'uses' => 'PagesController@post']);
    Route::get('/category/{categories}', ['as' => 'web.category', 'uses' => 'PagesController@category']);

});

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'dashboard', 'middleware' => 'authorized:view-dashboard'], function () {
    Route::get('/{vue_capture?}', function () {
        return view('admin.index');
    })->where('vue_capture', '[\/\w\.-]*');
});

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
Route::auth(['verify' => false]);
