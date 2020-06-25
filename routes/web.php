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
    Route::get('/change_locale/{locale}', 'Home\HomeController@changeLocale')
            ->middleware('locale')
            ->name('home-locale');

    Route::get('/', 'Home\HomeController@index')
            ->name('home');

    Route::group(['prefix' => 'me'], function () {
        Route::get('/profile', 'Home\UserController@showProfile')->name('home-me-profile-show');
        Route::post('/update_profile', 'Home\UserController@updateProfile')
                ->name('home-me-profile-update');
        Route::post('/update_password', 'Home\UserController@updatePassword')
                ->name('home-me-password-update');
    });

    Route::group(['prefix' => 'course'], function () {
        Route::get('/in_lang/{language_slug}', 'Home\CourseController@list')
                ->name('home-course-list');
        Route::get('/{code}', 'Home\CourseController@show')
                ->name('home-course-show');
        Route::get('/{code}/{lesson_number}', 'Home\LessonController@show')
                ->name('home-lesson-show');
    });

    Route::group(['prefix' => 'user_course'], function () {
        Route::post('/store', 'Home\UserCourseController@store')
                ->name('home-user-course-store');

        Route::get('/ajax_progress/{code}', 'Home\UserCourseController@ajaxProgressData')
                ->name('home-user-course-progress');
    });

    Route::group(['prefix' => 'test_type'], function () {
        Route::get('/in_lang/{language_slug}', 'Home\TestTypeController@list')
                ->name('home-test-type-list');
        Route::get('/{slug}', 'Home\TestTypeController@show')
                ->name('home-test-type-show');
    });

    Route::group(['prefix' => 'test'], function () {
        Route::get('overall/{type_slug}/{code}', 'Home\TestController@showOverall')
                ->name('home-test-show-overall');
        Route::get('sheet/{type_slug}/{code}', 'Home\TestController@showTestSheet')
                ->name('home-test-show-sheet');
    });

    Route::group(['prefix' => 'user_test'], function () {
        Route::post('/store', 'Home\UserTestController@store')
                ->name('home-user-test-store');

        Route::get('/ajax_attempt/{test_id}', 'Home\UserTestController@ajaxAttemptData')
                ->name('home-user-test-attempt-ajax');
    });

    Route::group(['prefix' => 'word_categories'], function() {
        Route::get('/{language_slug}', 'Home\WordCategoryController@list')
                ->name('home-word-categories-list');
    });

    Route::group(['prefix' => 'forum'], function () {
        Route::get('/{language_slug}', 'Home\TopicController@list')
                ->name('home-topic-list');
        Route::get('/{language_slug}/tag/{key}', 'Home\TopicController@listByTag')
                ->name('home-topic-list-by-tag');
        Route::get('/{language_slug}/create', 'Home\TopicController@create')
                ->name('home-topic-create');
        Route::get('/{language_slug}/show/{id}', 'Home\TopicController@show')
                ->name('home-topic-show');
        Route::get('/{language_slug}/edit/{id}', 'Home\TopicController@edit')
                ->name('home-topic-edit');
    });

    Route::group(['prefix' => 'topic'], function () {
        Route::post('/store', 'Home\TopicController@store')
                ->name('home-topic-store');
        Route::post('/ajax_available/{id}', 'Home\TopicController@ajaxAvailable')
                ->name('home-topic-available-ajax');
        Route::post('/update/{id}', 'Home\TopicController@update')
                ->name('home-topic-update');
        Route::post('/delete/{id}', 'Home\TopicController@destroy')
                ->name('home-topic-delete');
    });

    Route::group(['prefix' => 'reply'], function () {
        Route::post('/ajax_store', 'Home\ReplyController@ajaxStore')
                ->name('home-reply-store-ajax');
        Route::post('/ajax_delete', 'Home\ReplyController@ajaxDestroy')
                ->name('home-reply-delete-ajax');
        Route::post('/ajax_approve', 'Home\ReplyController@ajaxApprove')
                ->name('home-reply-approve-ajax');
    });

    Route::group(['prefix' => 'tutor'], function () {
        Route::get('/{language_slug}', 'Home\TutorContactController@list')
                ->name('home-tutor-list');
    });

    Route::group(['prefix' => 'thread'], function () {
        Route::get('/list', 'Home\ThreadController@list')
                ->name('home-thread-list');
        Route::get('/show/{code}', 'Home\ThreadController@show')
                ->name('home-thread-show');
        Route::post('/ajax_store', 'Home\ThreadController@ajaxStore')
                ->name('home-thread-store-ajax');
        Route::post('/ajax_update_sheet/{id}', 'Home\ThreadController@ajaxUpdateSheet')
                ->name('home-thread-update-sheet-ajax');
    });

    Route::group(['prefix' => 'chat'], function () {
        Route::post('/ajax_store', 'Home\ChatController@ajaxStore')
                ->name('home-chat-store-ajax');
    });

    Route::group(['prefix' => 'notification'], function () {
        Route::get('/ajax_load_unread', 'Home\NotificationController@ajaxLoadUnread')
                ->name('home-noti-load-unread-ajax');
        Route::post('/redirect_by_noti', 'Home\NotificationController@redirectByNoti')
                ->name('home-noti-redirect-read');
    });

    Route::post('/search', 'Home\SearchController@search')
            ->name('home-search');
});

Route::group(['prefix' => 'admin'], function () {
    Route::get('/change_locale/{locale}', 'Admin\AdminController@changeLocale')
            ->middleware('locale')
            ->name('admin-locale');

    Route::get('/', 'Admin\AdminController@index')
            ->name('admin');

    Route::group(['prefix' => 'users'], function () {
        Route::get('/', 'Admin\UserController@list')->name('admin-users-list');
        Route::post('/store', 'Admin\UserController@store')
                ->name('admin-users-store');
        Route::post('/update/{id}', 'Admin\UserController@update')
                ->name('admin-users-update');
        Route::post('/delete/{id}', 'Admin\UserController@destroy')
                ->name('admin-users-delete');
        Route::post('/update_roles/{id}', 'Admin\UserController@updateRoles')
                ->name('admin-users-update-roles');
        Route::post('/update_permissions/{id}', 'Admin\UserController@updatePermissions')
                ->name('admin-users-update-permissions');
    });
    
    Route::group(['prefix' => 'languages'], function () {
        Route::get('/', 'Admin\LanguageController@list')
                ->name('admin-languages-list');
        Route::post('/store', 'Admin\LanguageController@store')
                ->name('admin-languages-store');
        Route::post('/update/{id}', 'Admin\LanguageController@update')
                ->name('admin-languages-update');
        Route::post('/delete/{id}', 'Admin\LanguageController@destroy')
                ->name('admin-languages-delete');
    });
    
    Route::group(['prefix' => 'courses'], function () {
        Route::get('/', 'Admin\CourseController@list')
                ->name('admin-courses-list');
        Route::get('/show/{id}', 'Admin\CourseController@show')
                ->name('admin-courses-show');
        Route::post('/store', 'Admin\CourseController@store')
                ->name('admin-courses-store');
        Route::post('/update/{id}', 'Admin\CourseController@update')
                ->name('admin-courses-update');
        Route::post('/delete/{id}', 'Admin\CourseController@destroy')
                ->name('admin-courses-delete');
        Route::post('/available/{id}', 'Admin\CourseController@available')
                ->name('admin-courses-available');
    });
    
    Route::group(['prefix' => 'test-types'], function () {
        Route::get('/', 'Admin\TestTypeController@list')
                ->name('admin-test-types-list');
        Route::post('/store', 'Admin\TestTypeController@store')
                ->name('admin-test-types-store');
        Route::post('/update/{id}', 'Admin\TestTypeController@update')
                ->name('admin-test-types-update');
        Route::post('/delete/{id}', 'Admin\TestTypeController@destroy')
                ->name('admin-test-types-delete');
        Route::post('/available/{id}', 'Admin\TestTypeController@available')
                ->name('admin-test-types-available');
    });

    Route::group(['prefix' => 'test-type-rules'], function () {
        Route::post('/store', 'Admin\TestTypeRuleController@store')
                ->name('admin-test-type-rules-store');
        Route::post('/update/{id}', 'Admin\TestTypeRuleController@update')
                ->name('admin-test-type-rules-update');
        Route::post('/delete/{id}', 'Admin\TestTypeRuleController@destroy')
                ->name('admin-test-type-rules-delete');
    });

    Route::group(['prefix' => 'tests'], function () {
        Route::get('/', 'Admin\TestController@list')
                ->name('admin-tests-list');
        Route::get('/show/{id}', 'Admin\TestController@show')
                ->name('admin-tests-show');
        Route::post('/store', 'Admin\TestController@store')
                ->name('admin-tests-store');
        Route::post('/update/{id}', 'Admin\TestController@update')
                ->name('admin-tests-update');
        Route::post('/delete/{id}', 'Admin\TestController@destroy')
                ->name('admin-tests-delete');
        Route::post('/available/{id}', 'Admin\TestController@available')
                ->name('admin-tests-available');
    });

    Route::group(['prefix' => 'test-parts'], function () {
        Route::post('/store', 'Admin\TestPartController@store')
                ->name('admin-test-parts-store');
        Route::post('/update/{id}', 'Admin\TestPartController@update')
                ->name('admin-test-parts-update');
        Route::post('/delete/{id}', 'Admin\TestPartController@destroy')
                ->name('admin-test-parts-delete');
    });
    
    Route::group(['prefix' => 'test-quizzes'], function () {
        Route::post('/store', 'Admin\TestQuizController@store')
                ->name('admin-test-quizzes-store');
        Route::post('/update/{id}', 'Admin\TestQuizController@update')
                ->name('admin-test-quizzes-update');
        Route::post('/delete/{id}', 'Admin\TestQuizController@destroy')
                ->name('admin-test-quizzes-delete');
    });

    Route::group(['prefix' => 'lessons'], function () {
        Route::post('/store', 'Admin\LessonController@store')
                ->name('admin-lessons-store');
        Route::post('/update/{id}', 'Admin\LessonController@update')
                ->name('admin-lessons-update');
        Route::post('/delete/{id}', 'Admin\LessonController@destroy')
                ->name('admin-lessons-delete');
    });

    Route::group(['prefix' => 'word_categories'], function () {
        Route::get('/', 'Admin\WordCategoryController@list')
                ->name('admin-word-categories-list');
        Route::post('/store', 'Admin\WordCategoryController@store')
                ->name('admin-word-categories-store');
        Route::post('/update/{id}', 'Admin\WordCategoryController@update')
                ->name('admin-word-categories-update');
        Route::post('/delete/{id}', 'Admin\WordCategoryController@destroy')
                ->name('admin-word-categories-delete');
    });

    Route::group(['prefix' => 'words'], function () {
        Route::get('/', 'Admin\WordController@list')
                ->name('admin-words-list');
        Route::post('/store', 'Admin\WordController@store')
                ->name('admin-words-store');
        Route::post('/update/{id}', 'Admin\WordController@update')
                ->name('admin-words-update');
        Route::post('/delete/{id}', 'Admin\WordController@destroy')
                ->name('admin-words-delete');
    });

    Route::group(['prefix' => 'permissions'], function () {
        Route::get('/', 'Admin\PermissionController@list')
                ->name('admin-permissions-list');
        Route::post('/store', 'Admin\PermissionController@store')
                ->name('admin-permissions-store');
        Route::post('/update/{id}', 'Admin\PermissionController@update')
                ->name('admin-permissions-update');
        Route::post('/delete/{id}', 'Admin\PermissionController@destroy')
                ->name('admin-permissions-delete');
    });

    Route::group(['prefix' => 'roles'], function () {
        Route::get('/', 'Admin\RoleController@list')
                ->name('admin-roles-list');
        Route::post('/store', 'Admin\RoleController@store')
                ->name('admin-roles-store');
        Route::post('/update/{id}', 'Admin\RoleController@update')
                ->name('admin-roles-update');
        Route::post('/delete/{id}', 'Admin\RoleController@destroy')
                ->name('admin-roles-delete');
    });

    Route::group(['prefix' => 'tutor_contacts'], function () {
        Route::get('/', 'Admin\TutorContactController@list')
                ->name('admin-tutor-contacts-list');
        Route::post('/store', 'Admin\TutorContactController@store')
                ->name('admin-tutor-contacts-store');
        Route::post('/update/{id}', 'Admin\TutorContactController@update')
                ->name('admin-tutor-contacts-update');
        Route::post('/delete/{id}', 'Admin\TutorContactController@destroy')
                ->name('admin-tutor-contacts-delete');
    });
});
