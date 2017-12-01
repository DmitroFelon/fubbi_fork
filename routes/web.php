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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::post('stripe/webhook', '\Laravel\Cashier\Http\Controllers\WebhookController@handleWebhook');

Route::middleware(['auth'])->group(function () {

	Route::resource('projects', 'ProjectController');

	Route::resource('project.outlines', 'OutlineController');

	Route::resource('project.articles', 'ArticlesController');

	Route::resource('annotations', 'AnnotationController'); //TODO remove it

	Route::resource('teams', 'TeamController');

	Route::resource('users', 'UserController');

	Route::post('subscribe', 'SubscriptionController@subscribe');

	Route::get('alerts', 'NotificationController@show');

	Route::get('notification/read/{id?}', 'NotificationController@read');

	Route::get('/{page?}/{action?}/{id?}', 'DashboardController@index');
});





