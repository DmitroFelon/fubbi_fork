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

use App\Mail\UserRegistered;
use App\Services\Google\Drive;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::post('stripe/webhook', 'WebhookController@handleWebhook');

Auth::routes();

Route::get('test', function (FPDF $pdf) {

    $project = \App\Models\Project::find(11);

    $meta = $project->getMeta();

    dd($meta);

    $skip = [
        'quora_username',
        'quora_password',
        'keywords',
        'questions',
        'themes',
        'themes_order',
        'conversation_id',
        'keywords_questions',
        'keywords_meta',
        'seo_first_name',
        'seo_last_name',
        'seo_email',
        'google_access',
        'export',

    ];

    $meta = $meta->filter(function ($item, $key) use ($skip) {
        if (strpos($key, 'modificator_') !== false) {
            return null;
        }
        if (in_array($key, $skip)) {
            return null;
        }
        return $item;
    });

    $chunks = $meta->chunk(4);


    $pdf->AddPage();

    foreach ($chunks as $chunk) {
        $pdf->SetFont('Arial', '', 10);
        foreach ($chunk->keys() as $key) {
            if ($chunk->get($key) and !empty($chunk->get($key))) {
                $pdf->Cell(25, 5, $key);
            } else {
                continue;
            }
        }
        $pdf->Ln(10);
        foreach ($chunk as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $sub_value) {
                    if ($sub_value) {
                        $pdf->Cell(25, 6, $sub_value);
                        $pdf->Ln(5);
                    }
                }
            } else {
                $pdf->Cell(25, 6, $value);
                $pdf->Ln(5);
            }
        }
        $pdf->Ln(10);
    }
    return response($pdf->Output('S'))
        ->header('Content-Type', 'application/pdf');
});

Broadcast::routes();
//chat
Broadcast::channel('App.User.{user_id}', function ($user, $user_id) {
    return true;
});

//Notifications and messages
Broadcast::channel('conversation.{conversation_id}', function ($user, $conversation_id) {
    $conversation = \Musonza\Chat\Facades\ChatFacade::conversation($conversation_id);
    if (!$conversation) {
        return false;
    }
    return ($conversation->users()->where('id', $user->id))
        ? ['id' => $user->id, 'name' => $user->name] : false;
});

Route::middleware(['auth'])->group(function () {

    Route::group(['middleware' => ['role:admin']], function () {

        Route::get('charges', ['uses' => 'ChargesController@index', 'as' => 'charges']);

        Route::resources([
            'plans'       => 'PlanController',
            'help_videos' => 'HelpVideosController'
        ]);
    });

    Route::prefix('notification')->group(
        function () {
            Route::get('show/{id}', 'NotificationController@show');
            Route::get('read/{id?}', 'NotificationController@read');
            Route::get('', 'NotificationController@index');
        }
    );

    Route::prefix('project')->group(
        function () {
            Route::group(['middleware' => ['role:admin|account_manager']], function () {
                Route::get('accept_review/{project}', "ProjectController@accept_review");
                Route::get('reject_review/{project}', "ProjectController@reject_review");
            });
            Route::get('apply_to_project/{project}', "ProjectController@apply_to_project");
            Route::get('decline_project/{project}', "ProjectController@decline_project");
        }
    );

    Route::prefix('projects')->group(function () {
        Route::post('{project}/prefill', 'ProjectController@prefill');
        Route::put('{project}/prefill', 'ProjectController@prefill');
        Route::post('{project}/prefill_files', 'ProjectController@prefill_files');
        Route::post('{project}/prefill_meta_files', 'ProjectController@prefill_meta_files');
        Route::get('{project}/get_stored_files', 'ProjectController@get_stored_files');
        Route::get('{project}/remove_stored_file/{media}', 'ProjectController@remove_stored_files');
        Route::get('{project}/export', 'ProjectController@export');
        Route::get('{project}/resume', 'ProjectController@resume');
        Route::post('{project}/invite_users', 'ProjectController@invite_users');
        Route::post('{project}/invite_team', 'ProjectController@invite_team');
    });

    Route::namespace('Project')->group(
        function () {
            Route::prefix('project')->group(function () {
                Route::get('{project}/articles/{article}/accept', 'ArticlesController@accept');
                Route::get('{project}/articles/{article}/decline', 'ArticlesController@decline');
                Route::post('{project}/articles/{article}/save_social_posts', 'ArticlesController@save_social_posts');
            });

            Route::resources([
                'project.articles' => 'ArticlesController',
                'project.plan'     => 'PlanController',
            ]);
        }
    );

    Route::prefix('teams')->group(function () {
        Route::get('accept/{team}', 'TeamController@accept');
        Route::get('decline/{team}', 'TeamController@decline');
    });

    Route::prefix('messages')->group(function () {
        Route::get('read/{id}', 'MessageController@read');
        Route::get('clear', 'MessageController@clear');
    });

    Route::post('subscribe', 'SubscriptionController');

    Route::get('keywords/{project}/{theme}', 'KeywordsController@index');

    Route::prefix('settings')->group(function () {
        Route::post('billing', 'SettingsController@billing');
        Route::post('', 'SettingsController@save');
        Route::get('', ['as' => 'settings', 'uses' => 'SettingsController@index']);
    });

    Route::prefix('articles')->group(function () {
        Route::get('request_access/{article}', 'ArticlesController@request_access');
    });

    Route::resources(
        [
            'projects' => 'ProjectController',
            'messages' => 'MessageController',
            'users'    => 'UserController',
            'teams'    => 'TeamController',
            'issues'   => 'IssueController',
            'articles' => 'ArticlesController',
        ]
    );

    Route::get('/{page?}/{action?}/{id?}', 'DashboardController@index');
});
