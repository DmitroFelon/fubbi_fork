<?php

namespace App\Observers;

use App\Models\Project;
use App\Observers\Traits\Project\Keywords;
use App\Observers\Traits\Project\States;
use App\Observers\Traits\Project\Workers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectObserver
{
	use Keywords, Workers, States;

	protected $user;

	protected $request;

	public function __construct(Request $request)
	{
		$this->user    = Auth::user();
		$this->request = $request;
	}

	public function created(Project $project)
	{
		$should_be_notified = [
			'admin' => '\App\Notifications\Project\Created',
			'account_manager' => '\App\Notifications\Project\Created',
			'writer' => '\App\Notifications\Project\Created',
			'editor' => '\App\Notifications\Project\Created',
			'designer' => '\App\Notifications\Project\Created'
		];

		//todo send different notifications to client admins and workers
		$this->user->notify(new \App\Notifications\Project\Created($project));

		foreach ($should_be_notified as $role => $model){
			$users = User::withRole($role)->get();
			$users->each(function (User $item, $key) use ($project, $model) {
				$item->notify(new $model($project));
			});
		}
	}
}