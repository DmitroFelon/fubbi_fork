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

use App\Models\Project;
use App\Models\Team;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Auth::routes();

//TODO add resource controllers, attach to existed views

Route::get('/test', function () {

    foreach (\App\Models\Keyword::distinct()->get() as $item) {
        echo $item->text."<br>";
    }


    
});

Route::get('/{page?}/{action?}/{id?}', 'DashboardController@index')->middleware('auth');


