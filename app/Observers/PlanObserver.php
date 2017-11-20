<?php
/**
 * Created by PhpStorm.
 * User: imad
 * Date: 20/11/17
 * Time: 09:07
 */

namespace App\Observers;

use App\Models\Plan;

class PlanObserver
{
	public function created(Plan $plan)
	{
		\Stripe\Plan::create([
			"name"     => $plan->name,
			"id"       => $plan->stripe_plan_id,
			"interval" => "month",
			"currency" => "usd",
			"amount"   => $plan->amount,
		]);
	}

	public function updated(Plan $plan)
	{

	}

	public function deleted(Plan $plan)
	{
		$stripePlan = \Stripe\Plan::retrieve($plan->stripe_plan_id);
		$stripePlan->delete();
	}
}