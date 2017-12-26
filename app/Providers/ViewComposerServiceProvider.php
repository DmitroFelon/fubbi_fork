<?php
/**
 * Created by PhpStorm.
 * User: imad
 * Date: 17/10/17
 * Time: 20:26
 */

namespace App\Providers;

use App\ViewComposers\LeftMenuComposer;
use App\ViewComposers\MasterComposer;
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
        View::composer('layouts.navigation', LeftMenuComposer::class);
        View::composer('layouts.topnavbar', TopMenuComposer::class);
        View::composer('master', MasterComposer::class);

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