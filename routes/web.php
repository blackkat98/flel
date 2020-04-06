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

Route::get('/', function () {
    return redirect()->route('home');
});

Auth::routes();

Route::group(['prefix' => 'home'], function () {
    Route::get('/', 'Home\HomeController@index')->name('home');
});

Route::group(['prefix' => 'admin'], function () {
    Route::get('/', 'Admin\AdminController@index')->name('admin');
    
    Route::group(['prefix' => 'languages'], function () {
        Route::get('/', 'Admin\LanguageController@list')->name('admin-languages-list');
        Route::post('/store', 'Admin\LanguageController@store')->name('admin-languages-store');
        Route::post('/update/{id}', 'Admin\LanguageController@update')->name('admin-languages-update');
        Route::post('/delete/{id}', 'Admin\LanguageController@destroy')->name('admin-languages-delete');
    });
    
    Route::group(['prefix' => 'courses'], function () {
        Route::get('/', 'Admin\CourseController@list')->name('admin-courses-list');
        Route::post('/store', 'Admin\CourseController@store')->name('admin-courses-store');
        Route::post('/update/{id}', 'Admin\CourseController@update')->name('admin-courses-update');
        Route::post('/delete/{id}', 'Admin\CourseController@destroy')->name('admin-courses-delete');
    });
    
    Route::group(['prefix' => 'test-types'], function () {
        Route::get('/', 'Admin\TestTypeController@list')->name('admin-test-types-list');
        Route::post('/store', 'Admin\TestTypeController@store')->name('admin-test-types-store');
        Route::post('/update/{id}', 'Admin\TestTypeController@update')->name('admin-test-types-update');
        Route::post('/delete/{id}', 'Admin\TestTypeController@destroy')->name('admin-test-types-delete');
    });
});
