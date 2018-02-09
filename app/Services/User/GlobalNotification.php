<?php
/**
 * Created by PhpStorm.
 * User: imad
 * Date: 2/8/18
 * Time: 2:04 PM
 */

namespace App\Services\User;


use App\Models\Helpers\ProjectStates;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class GlobalNotification
{

    protected $user;

    public function make()
    {
        if (!Auth::check()) {
            return;
        }
        $role       = Auth::user()->role;
        $this->user = Auth::user();
        if (method_exists($this, $role)) {
            call_user_func([$this, $role]);
        }

    }

    private function client()
    {
        $filling_states = [
            ProjectStates::QUIZ_FILLING,
            ProjectStates::KEYWORDS_FILLING,
        ];

        $projects = $this->user->projects()->whereIn('state', $filling_states)->where('created_at', '<', now()->subDay())->get();

        if ($projects->isNotEmpty()) {
            $message = 'Please, continue filling project: <br>';

            $projects->each(function (Project $project) use (&$message) {
                $message .= '<a href="' . action('Resources\ProjectController@show', $project) . '>' . $project->name . '</a><br>';
            });

            $this->push('info', $message);
        }

    }

    private function account_manager()
    {

    }

    private function writer()
    {

    }

    private function designer()
    {

    }

    private function editor()
    {

    }

    private function researcher()
    {

    }

    private function push(string $type, string $value)
    {
        Session::push($type, $value);
    }

}