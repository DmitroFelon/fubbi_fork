<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
	public function subscribe(Request $request)
	{
		/*Auth::user()
			->newSubscription('new project', $request->input('plan_id'))
			->create($request->input('stripeToken'));*/


		return redirect()->action('ProjectController@index')->with('test', Auth::user());
    }
}
