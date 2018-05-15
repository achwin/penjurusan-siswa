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

Route::get('/',['as'=>'admin.index', 'uses'=>'HomeController@index']);

Route::group(['middleware' => 'auth'], function () {
    //    Route::get('/link1', function ()    {
//        // Uses Auth Middleware
//    });

    //Please do not remove this if you want adminlte:route and adminlte:link commands to works correctly.
    #adminlte_routes
    Route::group(['prefix'=>'input-data'], function(){
        Route::get('/','Admin\DataController@inputData');
        Route::post('/','Admin\DataController@postInputData');
    });
    Route::group(['prefix'=>'data-siswa'], function(){
        Route::get('/','Admin\DataController@index');
        Route::get('/delete/{period_id}','Admin\DataController@delete');
        Route::get('/detail/{period_id}','Admin\DataController@detail');
        Route::get('/export/{period_id}','Admin\DataController@export');
    });     
});
