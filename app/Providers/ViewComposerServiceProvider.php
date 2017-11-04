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

class ViewComposerServiceProvider extends ServiceProvider
{
    protected $admin_resourses = [
        'clients' => 'App\ViewComposers\Pages\Admin\Clients\All',
        'designers' => 'App\ViewComposers\Pages\Admin\Designers\All',
        'managers' => 'App\ViewComposers\Pages\Admin\Managers\All',
        'plans' => 'App\ViewComposers\Pages\Admin\Plans\All',
        'projects' => 'App\ViewComposers\Pages\Admin\Projects\All',
        'teams' => 'App\ViewComposers\Pages\Admin\Teams\All',
        'writers' => 'App\ViewComposers\Pages\Admin\Writers\All',
    ];

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        /*Navigation*/
        View::composer('partials.top-nav', TopMenuComposer::class);
        View::composer('partials.left-sidebar', LeftMenuComposer::class);

        /*Admin pages*/
        foreach ($this->admin_resourses as $view => $composer) {
            View::composer("pages.admin.{$view}.main", $composer);
            unset($view, $composer);
        }
        /*Client pages*/
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