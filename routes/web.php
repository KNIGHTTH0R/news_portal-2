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
Route::get('/tag/{tag}', 'IndexController@newsFromTag');
Route::post('/subscribe', 'IndexController@subscribe');
Route::get('/analytical/news', 'IndexController@analyticalNews');
Route::get('/analytical/{}', 'IndexController@analyticalNew');
Route::post('/search', 'IndexController@newsFilterSearch');
Route::get('/search/', 'IndexController@newsFilterSearchPaginate');

Route::get('/user/comments/{user}', 'IndexController@userComments');

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
    Route::group(['prefix' => 'comments-validation'], function (){
        Route::get('/', 'CommentValidateController@index');
        Route::put('/', 'CommentValidateController@allow');
        Route::patch('/', 'CommentValidateController@update');
        Route::delete('/', 'CommentValidateController@destroy');

        Route::put('/mass', 'CommentValidateController@massAllow');
        Route::delete('/mass', 'CommentValidateController@massDestroy');

    });

    Route::group(['prefix' => 'category'], function (){
        Route::get('/', 'CategoryController@index');
        Route::get('/create', 'CategoryController@create');
        Route::get('/{slug}/edit', 'CategoryController@edit');
        Route::post('/', 'CategoryController@store');
        Route::put('/{id}', 'CategoryController@update');
        Route::delete('/{id}', 'CategoryController@destroy');
    });

    Route::group(['prefix' => 'advertisement'], function (){
        Route::get('/', 'AdvertisementController@index');
        Route::get('/create/{side}/{position}', 'AdvertisementController@create');
        Route::get('/{id}/edit', 'AdvertisementController@edit');
        Route::post('/', 'AdvertisementController@store');
        Route::put('/{id}', 'AdvertisementController@update');
        Route::delete('/{id}', 'AdvertisementController@destroy');
    });


});

Route::group(['prefix' => 'api'], function (){
    Route::group(['prefix' => 'ajax'], function (){
        Route::post('upload_image', 'Admin\UploadImageController@store');
        Route::post('search', 'IndexController@searchTag');
        Route::post('active_check', 'IndexController@activeCheck');
        Route::group(['prefix' => 'comment', 'middleware' => 'auth', 'namespace' => 'Admin'], function (){
            Route::post('/', 'CommentController@set');
            Route::get('/', 'CommentController@get');
            Route::delete('/{id}', 'CommentController@destroy');
            Route::patch('/', 'CommentController@edit');

            Route::group(['prefix' => 'rate'], function () {
                Route::post('/up', 'CommentController@rate_up');
                Route::post('/down', 'CommentController@rate_down');
            });

        });
    });
    Route::group(['prefix' => 'other', 'namespace' => 'Admin'], function (){
        Route::get('css/custom.css', 'DynamicCssController@get');
        Route::post('css/custom.css', 'DynamicCssController@post');
        Route::delete('css/custom.css', 'DynamicCssController@destroy');
    });


});

Route::get('/{slug}', 'IndexController@newsFromCategory');
Route::get('/{category}/{slug}', 'IndexController@show');
