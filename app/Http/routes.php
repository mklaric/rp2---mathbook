<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::auth();

Route::get('/', 'HomeController@index');
Route::get('/home', function () {
    return redirect('/');
});
Route::get('/index', function () {
    return redirect('/');
});


Route::group(['middleware' => 'auth'], function () {
    Route::get('/profile', function () {
        return view('user.profile');
    });

    Route::get('/', 'NotificationsController@userNotifications');
    Route::get('/notifications', 'NotificationsController@userNotifications');
    Route::get('/tests', 'TestsController@index');
    Route::post('/pages/{page}/settings/admin/add', 'PagesController@addAdmin');
    Route::get('/pages/{page}/settings/admin/add', function () { abort(404); });
    Route::delete('/pages/{page}/settings/admin/delete', 'PagesController@deleteAdmin');
    Route::get('/pages/{page}/settings/admin/delete', function () { abort(404); });
    Route::post('/pages/{page}/settings/subscriber/add', 'PagesController@addSubscriber');
    Route::get('/pages/{page}/settings/subscriber/add', function () { abort(404); });
    Route::delete('/pages/{page}/settings/subscriber/delete', 'PagesController@deleteSubscriber');
    Route::get('/pages/{page}/settings/subscriber/delete', function () { abort(404); });
    Route::put('/pages/{page}/settings/sidebar/edit', 'PagesController@editSidebar');
    Route::get('/pages/{page}/settings/sidebar/edit', function () { abort(404); });

    Route::post('/pages/{page}/settings/modules/{module}/create', 'ModulesController@create');
    Route::get('/pages/{page}/settings/modules/{module}/create', function () { abort(404); });

    Route::post('/pages/{page}/settings/test/add', 'PageTestsController@create');
    Route::get('/pages/{page}/settings/test/add', function () { abort(404); });
    Route::delete('/pages/{page}/settings/test/delete', 'PageTestsController@delete');
    Route::get('/pages/{page}/settings/test/delete', function () { abort(404); });
    Route::post('/pages/{page}/test/generate','PageTestsController@generateTest');
    Route::post('/pages/{page}/test/finishGenerate','PageTestsController@generateTextofTasks');
    Route::post('/pages/{page}/test/endtest','PageTestsController@showUploadedFiles');
    Route::post('/pages/{page}/test/addFile','PageTestsController@addFile');
    Route::get('/pages/{page}/test/{user}/{task}', [ 'as' => 'show', 'uses' => 'PageTestsController@showFile']);

    Route::post('/pages/create', 'PagesController@create');
    Route::delete('/pages/delete', 'PagesController@delete');

    Route::post('/pages/{page}/notifications/add', 'NotificationsController@addPageNotification');

    Route::get('/pages/{page}/results/{fileid}', 'PageResultsController@showFile');
    Route::post('/pages/{page}/results/add', 'PageResultsController@addResult');
    Route::delete('/pages/{page}/results/delete', 'PageResultsController@deleteResult');
});

Route::get('/pages', 'PagesController@index');
Route::get('/pages/{page}', function ($page) { return redirect('/pages/' . $page . '/home'); });
Route::any('/pages/{page}/{module}', 'ModulesController@handler');
