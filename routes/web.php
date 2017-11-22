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

/*function isRevisionArray(Revision $history, $model, $parameter)
{
    $new = $history->newValue();
    $old = $history->oldValue();
    $new_array = json_decode($new, true);
    $old_array = json_decode($old, true);

    if (! is_array($new_array) and ! is_array($old_array)) {
        return false;
    }

    if (empty($new_array) and empty($old_array)) {
        return false;
    }

    $added_fields = array_values(array_diff($new_array, $old_array));

    $removed_fields = array_values(array_diff($old_array, $new_array));

    if (empty($added_fields) and empty($removed_fields)) {
        return false;
    }

    $added_string = '';

    $removed_string = '';

    foreach ($model::find($added_fields) as $field) {
        $added_string .= '`'.$field->$parameter.'`';
    }

    foreach ($model::find($removed_fields) as $field) {
        $removed_string .= '`'.$field->$parameter.'`';
    }

    

    $result = $history->userResponsible()->name;
    $added_string_result = ($added_string != '') ? ' added '.$added_string : '';
    $removed_string = ($removed_string != '') ? ' removed '.$removed_string : '';

    return $result.$added_string_result.$removed_string;
}*/

Route::resource('projects', 'ProjectController')->middleware('auth');

Route::resource('annotations', 'AnnotationController')->middleware('auth');

Route::resource('users', 'UserController')->middleware('auth');

Route::post('subscribe', 'SubscriptionController@subscribe')->middleware('auth');

Route::get('/{page?}/{action?}/{id?}', 'DashboardController@index')->middleware('auth');

Route::post('stripe/webhook', '\Laravel\Cashier\Http\Controllers\WebhookController@handleWebhook');
