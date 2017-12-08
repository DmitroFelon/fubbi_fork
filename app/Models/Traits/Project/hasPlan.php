<?php

namespace App\Models\Traits\Project;

use App\Models\Article;
use Illuminate\Support\Facades\Cache;
use Spatie\Tags\Tag;
use Stripe\Plan;

/**
 * Class hasPlan
 *
 * @package App\Models\Traits\Project
 */
trait hasPlan
{
	/**
	 * @param $value
	 * @return mixed
	 * 
	 * 
	 * Get Plan from Stripe api 
	 */
	public function getPlanAttribute($value)
	{
		return Cache::remember(
			'project_plan_'.$this->id,
			100,
			function () {
				return $this->plan = Plan::retrieve($this->subscription->stripe_plan);
			}
		);
	}

	/**
	 * @param $value
	 * @return array|mixed
	 * 
	 * Get metadata from Stripe Plan 
	 */
	public function getPlanMetadataAttribute($value)
	{
		if (isset($this->plan) and ! is_null($this->plan)) {
			return $this->plan->metadata->jsonSerialize();
		}

		return Plan::retrieve($this->subscription->stripe_plan)->metadata->jsonSerialize();
	}

	/**
	 * @param $service
	 * 
	 * Get each metadata as Project service
	 */
	public function getServiceName($service)
	{
		$plan_services = [
			'articles_count'     => __('Articles Count'),
			'articles_words'     => __('Articles Words'),
			'facebook_posts'     => __('Facebook Posts'),
			'instagram_posts'    => __('Instagram Posts'),
			'twitter_posts'      => __('Twitter Posts'),
			'pinterest_posts'    => __('Pinterest Posts'),
			'linkedin_posts'     => __('Linkedin Posts'),
			'marketing_calendar' => __('Marketing Calendar'),
			'linkedin_articles'  => __('Linkedin Articles'),
			'slideshare'         => __('Slideshare'),
			'medium'             => __('Medium'),
			'quora'              => __('Quora'),
		];
	}

	/**
	 * @param $service
	 * @return mixed
	 * 
	 * Get existed enity of service for current project
	 */
	public function getServiceResult($service)
	{
		return $this->articles()->withAnyTags([$service], 'service_type')->get();
	}

	/**
	 * @param $service
	 * @return mixed
	 * 
	 * Get outlined enity of service for current project
	 */
	public function getServiceOutlines($service)
	{
		return $this->outlines()->withAnyTags([$service], 'service_type')->get();
	}
}