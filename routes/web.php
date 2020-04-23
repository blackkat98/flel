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

    Route::group(['prefix' => 'users'], function () {
        Route::get('/', 'Admin\UserController@list')->name('admin-users-list');
        Route::post('/store', 'Admin\UserController@store')->name('admin-users-store');
        Route::post('/update/{id}', 'Admin\UserController@update')->name('admin-users-update');
        Route::post('/delete/{id}', 'Admin\UserController@destroy')->name('admin-users-delete');
    });
    
    Route::group(['prefix' => 'languages'], function () {
        Route::get('/', 'Admin\LanguageController@list')->name('admin-languages-list');
        Route::post('/store', 'Admin\LanguageController@store')->name('admin-languages-store');
        Route::post('/update/{id}', 'Admin\LanguageController@update')->name('admin-languages-update');
        Route::post('/delete/{id}', 'Admin\LanguageController@destroy')->name('admin-languages-delete');
    });
    
    Route::group(['prefix' => 'courses'], function () {
        Route::get('/', 'Admin\CourseController@list')->name('admin-courses-list');
        Route::get('/show/{id}', 'Admin\CourseController@show')->name('admin-courses-show');
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

    Route::group(['prefix' => 'tests'], function () {
        Route::get('/', 'Admin\TestController@list')->name('admin-tests-list');
        Route::get('/show/{id}', 'Admin\TestController@show')->name('admin-tests-show');
        Route::post('/store', 'Admin\TestController@store')->name('admin-tests-store');
        Route::post('/update/{id}', 'Admin\TestController@update')->name('admin-tests-update');
        Route::post('/delete/{id}', 'Admin\TestController@destroy')->name('admin-tests-delete');
    });

    Route::group(['prefix' => 'test-parts'], function () {
        Route::post('/store', 'Admin\TestPartController@store')->name('admin-test-parts-store');
        Route::post('/update/{id}', 'Admin\TestPartController@update')->name('admin-test-parts-update');
        Route::post('/delete/{id}', 'Admin\TestPartController@destroy')->name('admin-test-parts-delete');
    });
    
    Route::group(['prefix' => 'test-quizzes'], function () {
        Route::post('/store', 'Admin\TestQuizController@store')->name('admin-test-quizzes-store');
        Route::post('/update/{id}', 'Admin\TestQuizController@update')->name('admin-test-quizzes-update');
        Route::post('/delete/{id}', 'Admin\TestQuizController@destroy')->name('admin-test-quizzes-delete');
    });

    Route::group(['prefix' => 'lessons'], function () {
        Route::post('/store', 'Admin\LessonController@store')->name('admin-lessons-store');
        Route::post('/update/{id}', 'Admin\LessonController@update')->name('admin-lessons-update');
        Route::post('/delete/{id}', 'Admin\LessonController@destroy')->name('admin-lessons-delete');
    });

    Route::group(['prefix' => 'word_categories'], function () {
        Route::get('/', 'Admin\WordCategoryController@list')->name('admin-word-categories-list');
        Route::post('/store', 'Admin\WordCategoryController@store')->name('admin-word-categories-store');
        Route::post('/update/{id}', 'Admin\WordCategoryController@update')->name('admin-word-categories-update');
        Route::post('/delete/{id}', 'Admin\WordCategoryController@destroy')->name('admin-word-categories-delete');
    });
});
