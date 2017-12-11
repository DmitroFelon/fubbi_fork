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

Route::post('stripe/webhook', '\Laravel\Cashier\Http\Controllers\WebhookController@handleWebhook');

Auth::routes();

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

		Route::resource('projects', 'ProjectController');

		Route::resource('project.outlines', 'OutlineController');

		Route::resource('project.articles', 'ArticlesController');

		Route::resource('annotations', 'AnnotationController'); //TODO remove it

		Route::resource('teams', 'TeamController');

		Route::resource('users', 'UserController');

		Route::post('subscribe', 'SubscriptionController@subscribe');

		Route::get('/{page?}/{action?}/{id?}', 'DashboardController@index');
	}
);





