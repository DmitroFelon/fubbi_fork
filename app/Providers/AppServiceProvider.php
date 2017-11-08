<?php

namespace App\Providers;

use App\Models\Project;
use App\Models\Users\Client;
use App\Observers\ClientObserver;
use App\Observers\ProjectObserver;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
       
        Project::observe(ProjectObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
