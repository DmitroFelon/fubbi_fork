<?php

namespace App\Http\Middleware;

use App\Models\Helpers\ProjectStates;
use App\Models\Project;
use App\Models\Role;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Reminders
{

    protected $user;

    public function __construct()
    {
        $this->user = Auth::user();
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            return $next($request);
        }

        $user = $this->user;

        Session::remove('info');
        Session::remove('success');
        Session::remove('error');
        
        

        if ($user->role == Role::CLIENT) {
            $user->projects()->whereIn('state', [ProjectStates::QUIZ_FILLING, ProjectStates::KEYWORDS_FILLING])
                 ->get()
                 ->each(function (Project $project) {

                     $message = _i(
                         '<a class="text-info" href="%s">Please complete the project: "%s" </a>',
                         [action('ProjectController@edit', [$project, 's' => $project->state]), $project->name]
                     );

                     Session::flash('info', $message);
                 });

        }

        return $next($request);
    }
}
