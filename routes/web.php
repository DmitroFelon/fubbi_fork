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

use App\Services\Google\Drive;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::post('stripe/webhook', 'WebhookController@handleWebhook');

Auth::routes();

Route::get('test', function (Drive $api) {

    $listOfTags = Illuminate\Support\Arr::pluck(\App\Models\Role::all([
            'id', 'display_name'
        ]), 'display_name', 'id') + ['' => 'select role'];
    dd($listOfTags);
});

Route::middleware(['auth'])->group(
    function () {
        Route::prefix('notification')->group(
            function () {
                Route::get('show/{id}', 'NotificationController@show');
                Route::get('read/{id?}', 'NotificationController@read');
                Route::get('', 'NotificationController@index');
            }
        );
        Route::prefix('project')->group(
            function () {
                Route::get('accept_review/{project}', "ProjectController@accept_review");
                Route::get('reject_review/{project}', "ProjectController@reject_review");
                Route::get('apply_to_project/{project}', "ProjectController@apply_to_project");
                Route::get('decline_project/{project}', "ProjectController@decline_project");
            }
        );
        Route::get('projects/{project}/prefill', 'ProjectController@prefill');
        Route::get('projects/{project}/export', 'ProjectController@export');
        Route::resource('projects', 'ProjectController');
        Route::namespace('Project')->group(
            function () {
                Route::resource('project.outlines', 'OutlineController');
                Route::get('project/{project}/articles/{article}/accept', 'ArticlesController@accept');
                Route::get('project/{project}/articles/{article}/decline', 'ArticlesController@decline');
                Route::resource('project.articles', 'ArticlesController');
                Route::resource('project.plan', 'PlanController')->only(['show', 'index', 'update', 'edit']);
            }
        );
        Route::resource('teams', 'TeamController');
        Route::resource('users', 'UserController');
        Route::resource('plans', 'PlanController');
        Route::resource('articles', 'ArticlesController');
        Route::post('subscribe', 'SubscriptionController@subscribe');
        Route::get('keywords/{project}/{theme}', 'KeywordsController@index');
        Route::post('settings/billing', 'SettingsController@billing');
        Route::post('settings', 'SettingsController@save');
        Route::get('settings', 'SettingsController@index');
        Route::get('/{page?}/{action?}/{id?}', 'DashboardController@index');
    }
);





