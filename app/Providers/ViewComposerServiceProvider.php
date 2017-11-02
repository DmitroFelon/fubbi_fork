<?php
/**
 * Created by PhpStorm.
 * User: imad
 * Date: 17/10/17
 * Time: 20:26
 */

namespace App\Providers;

use App\ViewComposers\TopMenuComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('partials.top-nav', TopMenuComposer::class);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
    }
}