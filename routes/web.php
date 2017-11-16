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

Auth::routes();

Route::get('/', 'IndexController@index');

Route::group(['prefix' => 'news'], function (){
    Route::get('/', 'NewsController@index');
    Route::get('/create', 'NewsController@create');
    Route::get('/{slug}', 'NewsController@show');
    Route::get('/{slug}/edit', 'NewsController@edit');
    Route::post('/', 'NewsController@store');
    Route::put('/{id}', 'NewsController@update');
    Route::delete('/{id}', 'NewsController@destroy');
});


Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'web', 'isAdmin'], 'namespace' => 'Admin'], function (){
    Route::get('/', 'IndexController@index');
    Route::get('/css-editor', 'CssEditorController@index');
    Route::group(['prefix' => 'category'], function (){
        Route::get('/', 'CategoryController@index');
        Route::get('/create', 'CategoryController@create');
        Route::get('/{slug}/edit', 'CategoryController@edit');
        Route::post('/', 'CategoryController@store');
        Route::put('/{id}', 'CategoryController@update');
        Route::delete('/{id}', 'CategoryController@destroy');
    });

    Route::group(['prefix' => 'news'], function (){
        Route::get('/', 'NewsController@index');
        Route::get('/create', 'NewsController@create');
        Route::get('/{slug}', 'NewsController@show');
        Route::get('/{slug}/edit', 'NewsController@edit');
        Route::post('/', 'NewsController@store');
        Route::put('/{id}', 'NewsController@update');
        Route::delete('/{id}', 'NewsController@destroy');
    });
});

Route::group(['prefix' => 'api', 'namespace' => 'Admin'], function (){
    Route::group(['prefix' => 'ajax'], function (){
        Route::post('upload_image', 'UploadImageController@store');

        Route::group(['prefix' => 'comment', 'middleware' => 'auth'], function (){
            Route::post('/', 'CommentController@set');
            Route::get('/', 'CommentController@get');
            Route::delete('/{id}', 'CommentController@destroy');

            Route::group(['prefix' => 'rate'], function () {
                Route::post('/up', 'CommentController@rate_up');
                Route::post('/down', 'CommentController@rate_down');
            });

        });



    });
    Route::group(['prefix' => 'other'], function (){
        Route::get('css/custom.css', 'DynamicCssController@get');
        Route::post('css/custom.css', 'DynamicCssController@post');
        Route::delete('css/custom.css', 'DynamicCssController@destroy');
    });


});


Route::get('/{slug}', 'IndexController@newsFromCategory');
Route::get('/{category}/{slug}', 'IndexController@show');

//Route::get('/home', 'HomeController@index')->name('home');
//Route::get('/home', 'HomeController@index')->name('home');
