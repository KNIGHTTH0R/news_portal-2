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

Route::get('/', 'IndexController@index');

Route::post('upload_image', 'Admin\UploadImageController@store');


Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'web', 'isAdmin']], function (){
    Route::get('/', 'Admin\IndexController@index');
    Route::get('/css-editor', 'Admin\CssEditorController@index');

//    function (){
//
//        if (Storage::disk('local')->exists('custom_css/colors.json') == true) {
//            $colors = json_decode(Storage::disk('local')->get('custom_css/colors.json'), true);
//        } else {
//            $colors = [];
//        }
//        return view('admin.index', ['title' => 'Admin panel', 'colors' => $colors]);
//    });


    Route::group(['prefix' => 'category', 'namespace' => 'Admin'], function (){
        Route::get('/', 'CategoryController@index');
        Route::get('/create', 'CategoryController@create');
        Route::get('/{slug}/edit', 'CategoryController@edit');
        Route::post('/', 'CategoryController@store');
        Route::put('/{id}', 'CategoryController@update');
        Route::delete('/{id}', 'CategoryController@destroy');
    });

    Route::group(['prefix' => 'news', 'namespace' => 'Admin'], function (){
        Route::get('/', 'NewsController@index');
        Route::get('/create', 'NewsController@create');
        Route::get('/{slug}', 'NewsController@show');
        Route::get('/{slug}/edit', 'NewsController@edit');
        Route::post('/', 'NewsController@store');
        Route::put('/{id}', 'NewsController@update');
        Route::delete('/{id}', 'NewsController@destroy');
    });
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/css/custom.css', 'Admin\DynamicCssController@get');
Route::post('/css/custom.css', 'Admin\DynamicCssController@post');
Route::delete('/css/custom.css', 'Admin\DynamicCssController@destroy');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/{category}/{slug}', 'IndexController@show');
