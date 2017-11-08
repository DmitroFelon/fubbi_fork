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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

//TODO add resource controllers, attach to existed views

Route::get('/test', function () {

    $project = Project::find(1);

    //$project->name = 'some other cool name';

    //$project->save();

    //$project->syncKeywords([1, 2, 3, 4, 5, 6]);

    foreach ($project->keywords()->get() as $keyword) {
        echo $keyword->text."<br>";
    }

    foreach ($project->revisionHistory as $history) {

        $new = $history->newValue();

        $old = $history->oldValue();

        $new_array = json_decode($new, true);
        $old_array = json_decode($old, true);

        if(is_array($new_array) and is_array($old_array)){
            $new_string = '';
            foreach (\App\Models\Keyword::find($new_array) as $keyword){
                
            }
        }

        echo $history->userResponsible()->name.
            " changed `".$history->fieldName().
            "` from `".$old.
            '` to `'.$new."`<br>";
    }
});

Route::get('/{page?}/{action?}/{id?}', 'DashboardController@index')->middleware('auth');


