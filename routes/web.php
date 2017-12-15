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

Route::post('stripe/webhook', 'WebhookController@handleWebhook');

Auth::routes();

Route::get(
	'test',
	function () {

		//TODO use on for pre-filling

		//from database if exist
		$c1 = collect(
			[
				'theme1' => [
					'word 1' => false,
					'word 2' => true,
					'word 3' => true,
					'word 4' => false,
				],
				'theme2' => [
					'word 1' => false,
					'word 2' => false,
					'word 3' => false,
					'word 4' => false,
				],
				'theme3' => [
					'word 1' => true,
					'word 2' => true,
					'word 3' => true,
					'word 4' => true,
				],
			]
		);

		//user's input
		$c2 = collect(
			[
				'theme1' => [
					'word 1',
					'word 2',
				],
				'theme2' => [
					'word 2',
					'word 4',
				],
				'theme4' => [
					'word 1',
					'word 4',
					'word 3',
				],
			]
		);

		//fill by new keywords if necessary
		$c2->each(function($item, $k) use ($c1){
			if(!$c1->has($k)){
				$c1->put($k, []);
			}
		});

		$c1->transform(
			function ($item, $k) use ($c2, &$c1) {
				if ($c2->has($k)) {
					//set all to false
					foreach ($item as $i => $keyword) {
						$item[$i] = false;
					}
					//set true at existed
					foreach ($c2->get($k) as $i => $keyword) {
						$item[$keyword] = true;
					}
				}

				return $item;
			}
		);

		dd($c1->toArray());
	}
);

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
		Route::resource('projects', 'ProjectController');
		Route::namespace('Project')->group(
			function () {
				Route::resource('project.outlines', 'OutlineController');
				Route::resource('project.articles', 'ArticlesController');
				Route::resource('project.plan', 'PlanController')->only(['show', 'index', 'update', 'edit']);
			}
		);
		Route::resource('teams', 'TeamController');
		Route::resource('users', 'UserController');
		Route::resource('plans', 'PlanController');
		Route::post('subscribe', 'SubscriptionController@subscribe');
		Route::get('keywords/{project}/{theme}', 'KeywordsController@index');
		Route::get('/{page?}/{action?}/{id?}', 'DashboardController@index');
	}
);





