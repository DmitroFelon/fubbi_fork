<?php


namespace App\Models\Traits\Project;

use Illuminate\Support\Facades\Cache;
use Stripe\Plan;

trait hasPlan
{
	public function getPlanAttribute($value)
	{
		return Cache::remember('project_plan_'.$this->id, 100, function () {
			$this->plan = Plan::retrieve($this->subscription->stripe_plan);
			return $this->plan;
		} );
	}

	public function getPlanMetadataAttribute($value)
	{
		if(isset($this->plan) and !is_null($this->plan)){
			return $this->plan->metadata->jsonSerialize();
		}

		return Plan::retrieve($this->subscription->stripe_plan)->metadata->jsonSerialize();
	}

	
}