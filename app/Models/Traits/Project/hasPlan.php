<?php

namespace App\Models\Traits\Project;

use Illuminate\Support\Facades\Cache;
use Stripe\Plan;

/**
 * Class hasPlan
 *
 * @package App\Models\Traits\Project
 */
trait hasPlan
{
    use hasModifications;

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
            'stripe_plan_' . $this->subscription->stripe_plan,
            1,
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
        return (isset($this->plan) and !is_null($this->plan)) ? collect(
            $this->plan->metadata->jsonSerialize()
        ) : collect(Plan::retrieve($this->subscription->stripe_plan)->metadata->jsonSerialize());
    }

    /**
     * @param $service
     *
     * Get each metadata as Project service
     */
    public function getServiceName(string $service, $countable = false)
    {
        $plan_services = [
            'articles_count'     => _i('Articles Count'),
            'articles_words'     => _i('Articles Words'),
            'facebook_posts'     => _i('Facebook Posts'),
            'instagram_posts'    => _i('Instagram Posts'),
            'twitter_posts'      => _i('Twitter Posts'),
            'pinterest_posts'    => _i('Pinterest Posts'),
            'linkedin_posts'     => _i('Linkedin Posts'),
            'marketing_calendar' => _i('Marketing Calendar'),
            'linkedin_articles'  => _i('Linkedin Articles'),
            'slideshare'         => _i('Slideshare'),
            'medium'             => _i('Medium'),
            'quora'              => _i('Quora'),
        ];

        return $plan_services[$service] ?? '';
    }

    public function getVariableServices()
    {
        return [
            'facebook_posts',
            'instagram_posts',
            'twitter_posts',
            'pinterest_posts',
            'linkedin_posts',
            'linkedin_articles',
            'slideshare',
            'medium',
            'quora',
        ];
    }

    /**
     * @return array
     */
    public function getCountableServices()
    {
        return [
            'facebook_posts',
            'instagram_posts',
            'twitter_posts',
            'pinterest_posts',
            'linkedin_posts',
            'linkedin_articles',
            'slideshare',
            'medium',
            'quora',
        ];
    }

    /**
     * @param $service
     * @return mixed
     *
     * Get existed enity of service for current project
     */
    public function getServiceResult(string $service)
    {
        return $this->articles()->withAnyTags([$service], 'service_type')->get();
    }

    /**
     * @param $service
     * @return mixed
     *
     * Get outlined enity of service for current project
     */
    public function getServiceOutlines(string $service)
    {
        $r = $this->outlines()->withAnyTags([$service], 'service_type')->get();

        return $r;
    }

    /**
     * @param string $service
     */
    public function isRequireService(string $service)
    {
        $result = $this->plan_metadata->get($service);
        return ($result == false or $result == 'false' or $result == null)
            ? false
            : true;

    }
}