<?php

namespace App\Providers;

use App\Models\Project;
use App\Models\Users\Client;
use App\Observers\ClientObserver;
use App\Observers\ProjectObserver;
use Form;
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

        Form::component('bsText', 'components.form.text',
            ['name', 'value', 'label', 'description', 'attributes'=> []]
        );
        
        Form::component('bsSelect', 'components.form.select',
            ['name', 'list', 'selected', 'label', 'description', 'select_attributes' => [], 'options_attributes'=> []]
        );

        Form::component('bsTagInput', 'components.form.tag-input',
            ['name', 'label', 'description', 'attributes'=> []]
        );
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
