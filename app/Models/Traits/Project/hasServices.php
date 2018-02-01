<?php
/**
 * Created by PhpStorm.
 * User: imad
 * Date: 1/31/18
 * Time: 12:23 PM
 */

namespace App\Models\Traits\Project;


use App\Models\Project\Service;
use Stripe\Plan;

/**
 * Class hasServices
 * @package App\Models\Traits\Project
 */
trait hasServices
{

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function services()
    {
        return $this->hasMany(Service::class);
    }

    /**
     * @param Plan $plan
     */
    public function setServices(Plan $plan)
    {

        $services = collect();

        collect($plan->metadata->jsonSerialize())->each(function ($value, $key) use ($services) {
            $services->push(new Service([
                    'name'         => $key,
                    'display_name' => $this->getServiceName($key),
                    'default'      => $value,
                    'custom'       => null,
                    'type'         => $this->getServiceType($key)
                ])
            );
        });

        $this->services()->saveMany($services->toArray());
    }

    /**
     * @param string $service
     * @return string
     */
    public function getServiceType(string $service)
    {
        $int = [
            'articles_count',
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

        $bool = [
            'marketing_calendar'
        ];

        $range = [
            'articles_words'
        ];

        if (in_array($service, $int)) {
            return Service::TYPE_INTEGER;
        }
        if (in_array($service, $bool)) {
            return Service::TYPE_BOOLEAN;
        }
        if (in_array($service, $range)) {
            return Service::TYPE_RANGE;
        }

        return Service::TYPE_STRING;;
    }

}