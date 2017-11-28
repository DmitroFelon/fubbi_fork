<?php
/**
 * Created by PhpStorm.
 * User: imad
 * Date: 17/10/17
 * Time: 20:26
 */

namespace App\Providers;

use App\ViewComposers\LeftMenuComposer;
use App\ViewComposers\TopMenuComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

/**
 * Class ViewComposerServiceProvider
 *
 * @package App\Providers
 */
class ViewComposerServiceProvider extends ServiceProvider
{

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        /*
         * Navigation
         * */
        View::composer('partials.top-nav', TopMenuComposer::class);
        View::composer('layouts.navigation', TopMenuComposer::class);
        View::composer('partials.left-sidebar', LeftMenuComposer::class);

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