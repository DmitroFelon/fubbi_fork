<?php

namespace App\Providers;

use App\Models\Article;
use App\Models\Project;
use App\Models\Team;
use App\Policies\ArticlePolicy;
use App\Policies\ChargePolicy;
use App\Policies\PlanPolicy;
use App\Policies\ProjectPolicy;
use App\Policies\TeamPolicy;
use App\Policies\UserPolicy;
use App\User;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Musonza\Chat\Messages\Message;
use Stripe\Charge;
use Stripe\Plan;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Project::class => ProjectPolicy::class,
        User::class    => UserPolicy::class,
        Team::class    => TeamPolicy::class,
        Charge::class  => ChargePolicy::class,
        Plan::class    => PlanPolicy::class,
        Article::class => ArticlePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @param GateContract $gate
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        $gate->define('update-project', ProjectPolicy::class.'@update');
    }
}
