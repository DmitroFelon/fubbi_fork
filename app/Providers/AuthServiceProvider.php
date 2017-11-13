<?php

namespace App\Providers;

use App\Models\Project;
use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        $gate->before(function (User $user, $ability) {
            if ($user->getRole() == 'admin') {
                return true;
            }
            return false;
        });

        $gate->define('manage-project', function (User $user, Project $project) {
            return $user->id === $project->client_id;
        });
    }
}
