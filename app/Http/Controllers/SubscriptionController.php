<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
	public function subscribe(Request $request, Project $project)
	{
		$subsription = Auth::user()
			->newSubscription('new project', $request->input('plan_id'))
			->create($request->input('stripeToken'));

		return redirect()->action('ProjectController@edit')->with('subsription', $subsription);
    }
}
