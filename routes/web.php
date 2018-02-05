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

use App\Facades\ProjectExport;
use App\Notifications\RegistrationConfirmation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

//Stripe routes
Route::post('stripe/webhook', 'WebhookController@handleWebhook');

Route::post('thrivecart', 'TrivecartController@handle');

//Auth
Auth::routes();

//just for tests
Route::get('test', function () {
    $user = Activity::users()->where('user_id', 1)->get();
    dd($user);
});

Route::get('/test_email/{inex}', function ($inex) {

    $auth_user                = Auth::user();
    $demo_user                = \App\User::first();
    $demo_project             = \App\Models\Project::first();
    $demo_article             = $demo_project->articles()->first();
    $demo_invitations_team    = \App\Models\Invite::teams()->first();
    $demo_invitations_project = \App\Models\Invite::projects()->first();

    $notifications = [
        new RegistrationConfirmation($auth_user),

        new \App\Notifications\Worker\Attached($demo_project),
        new \App\Notifications\Worker\Detached($demo_project),
        new \App\Notifications\Worker\Progress($demo_project),

        new \App\Notifications\Team\Invite($demo_invitations_team),

        new \App\Notifications\Project\Delayed($demo_project),
        new \App\Notifications\Project\Filled($demo_project),
        //new \App\Notifications\Project\Invite($demo_invitations_project),
        new \App\Notifications\Project\Remind($demo_project),
        new \App\Notifications\Project\Removed($demo_project),
        new \App\Notifications\Project\Subscription($demo_project),
        new \App\Notifications\Project\ThirdArticleReject($demo_article),
        new \App\Notifications\Project\WillRemoved($demo_project),

        new \App\Notifications\Client\Registered($demo_user),


    ];

    $n        = $notifications[$inex];
    $mailable = new \App\Mail\TestingEmail($n->toMail($auth_user));

    return $mailable;
});

Route::get('cart_redirect', function (\Illuminate\Http\Request $request) {

    $customer_data = $request->input('thrivecart');
    $email         = $customer_data['customer']['email'] ?? false;

    if (!$email) {
        return redirect()->action('Auth\LoginController@login')->with('error', 'Session expired');
    }

    $user = \App\User::whereEmail($email)->firstOrFail();
    Auth::logout();
    Auth::login($user, true);

    \Illuminate\Support\Facades\Session::flash('change_password');

    return redirect()->action('SettingsController@index')->with('success', 'Please create a new password');
});

//Socket auth
Broadcast::routes();

Broadcast::channel('App.User.{user_id}', function ($user, $user_id) {
    return true;
});
//Notifications
Broadcast::channel('conversation.{conversation_id}', function ($user, $conversation_id) {
    $conversation = \Musonza\Chat\Facades\ChatFacade::conversation($conversation_id);
    if (!$conversation) {
        return false;
    }
    return ($conversation->users()->where('id', $user->id))
        ? ['id' => $user->id, 'name' => $user->name] : false;
});

//Main routes group
Route::middleware(['auth'])->group(function () {

    Route::group(['middleware' => ['role:admin']], function () {

        Route::get('charges', ['uses' => 'ChargesController@index', 'as' => 'charges']);

        Route::get('dashboard', ['uses' => 'DashboardController@dashboard', 'as' => 'dashboard']);
        Route::get('dashboard/preload/{view}', ['uses' => 'DashboardController@preloadView', 'as' => 'preloadView']);

        Route::resources([
            'plans'       => 'PlanController',
            'help_videos' => 'HelpVideosController'
        ]);
    });

    Route::get('dashboard', ['uses' => 'DashboardController@dashboard', 'as' => 'dashboard']);
    Route::get('dashboard/preload/{view}', ['uses' => 'DashboardController@preloadView', 'as' => 'preloadView']);

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
            Route::get('apply_to_project/{project}', "ProjectController@apply_to_project");


            Route::get('decline_project/{project}', "ProjectController@decline_project");
        }
    );

    Route::prefix('projects')->group(function () {
        Route::post('{project}/prefill', 'ProjectController@prefill');
        Route::put('{project}/prefill', 'ProjectController@prefill');
        Route::post('{project}/prefill_files', 'ProjectController@prefill_files');
        Route::get('{project}/get_stored_files', 'ProjectController@get_stored_files');
        Route::get('{project}/remove_stored_file/{media}', 'ProjectController@remove_stored_files');
        Route::get('{project}/export', 'ProjectController@export');
        Route::get('{project}/resume', 'ProjectController@resume');
        Route::post('{project}/invite_users', 'ProjectController@invite_users');
        Route::post('{project}/invite_team', 'ProjectController@invite_team');

        Route::get('{project}/remove_from_project/{user}', 'ProjectController@remove_from_project');
    });

    Route::prefix('ideas')->group(function () {
        Route::post('{idea}/prefill_meta_files', 'IdeaController@prefill_meta_files');
        Route::get('{idea}/get_stored_idea_files', 'IdeaController@get_stored_idea_files');
        Route::get('{idea}/remove_stored_file/{media}', 'IdeaController@remove_stored_files');
        Route::get('{idea}', 'IdeaController@show');
    });

    Route::namespace('Project')->group(
        function () {
            Route::prefix('project')->group(function () {
                Route::get('{project}/articles/{article}/accept', 'ArticlesController@accept');
                Route::get('{project}/articles/{article}/decline', 'ArticlesController@decline');
                Route::post('{project}/articles/{article}/save_social_posts', 'ArticlesController@save_social_posts');
                Route::post('{project}/articles/{article}/rate/', 'ArticlesController@rate');
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
        Route::get('user/{user}', 'MessageController@user');
        Route::get('clear', 'MessageController@clear');
    });

    Route::post('subscribe', 'SubscriptionController');

    Route::get('keywords/{project}/{idea}', 'KeywordsController@index');
    Route::get('research', 'ResearchController@index');
    Route::get('research/load', 'ResearchController@load');

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


});

Route::get('/{page?}/{action?}/{id?}', 'DashboardController@index');

