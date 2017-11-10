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
     * @var string
     */
    protected $pages_path = 'pages';

    /**
     * @var string
     */
    protected $composers_path = 'App\ViewComposers\Pages';

    /**
     * @var array
     */
    protected $composers = [
        'admin' => [
            'clients' => [
                'main' => 'All',
                'single' => 'Single',
                'edit' => 'Edit',
                'add' => 'Add',
            ],
            'designers' => [
                'main' => 'All',
                'single' => 'Single',
                'edit' => 'Edit',
                'add' => 'Add',
            ],
            'managers' => [
                'main' => 'All',
                'single' => 'Single',
                'edit' => 'Edit',
                'add' => 'Add',
            ],
            'plans' => [
                'main' => 'All',
                'single' => 'Single',
                'edit' => 'Edit',
                'add' => 'Add',
            ],
            'projects' => [
                'main' => 'All',
                'single' => 'Single',
                'edit' => 'Edit',
                'add' => 'Add',
            ],
            'teams' => [
                'main' => 'All',
                'single' => 'Single',
                'edit' => 'Edit',
                'add' => 'Add',
            ],
            'writers' => [
                'main' => 'All',
                'single' => 'Single',
                'edit' => 'Edit',
                'add' => 'Add',
            ],
        ],
        'client' => [
            'projects' => [
                'main' => 'All',
                'single' => 'Single',
                'edit' => 'Edit',
                'add' => 'Add',
            ]
        ]
    ];

    /**
     * @var array
     */
    protected $collections = [
        /*admin*/
        'admin.clients' => '\Admin\Clients\All',
        'admin.designers' => '\Admin\Designers\All',
        'admin.managers' => '\Admin\Managers\All',
        'admin.plans' => '\Admin\Plans\All',
        'admin.projects' => '\Admin\Projects\All',
        'admin.teams' => '\Admin\Teams\All',
        'admin.writers' => '\Admin\Writers\All',
        /*client*/
        'client.projects' => '\Client\Projects\All',
    ];
    /**
     * @var array
     */
    protected $singles = [
        /*admin*/
        'admin.clients' => '\Admin\Clients\Single',
        'admin.designers' => '\Admin\Designers\Single',
        'admin.managers' => '\Admin\Managers\Single',
        'admin.plans' => '\Admin\Plans\Single',
        'admin.projects' => '\Admin\Projects\Single',
        'admin.teams' => '\Admin\Teams\Single',
        'admin.writers' => '\Admin\Writers\Single',
        /*client*/
        'client.projects' => '\Client\Projects\Single',

    ];
    /**
     * @var array
     */
    protected $edits = [
        /*admin*/
        'admin.clients' => '\Admin\Clients\Edit',
        'admin.designers' => '\Admin\Designers\Edit',
        'admin.managers' => '\Admin\Managers\Edit',
        'admin.plans' => '\Admin\Plans\Edit',
        'admin.projects' => '\Admin\Projects\Edit',
        'admin.teams' => '\Admin\Teams\Edit',
        'admin.writers' => '\Admin\Writers\Edit',
        /*client*/
        'client.projects' => '\Client\Projects\Edit',
    ];
    /**
     * @var array
     */
    protected $adds = [
        /*admin*/
        'admin.clients' => '\Admin\Clients\Add',
        'admin.designers' => '\Admin\Designers\Add',
        'admin.managers' => '\Admin\Managers\Add',
        'admin.plans' => '\Admin\Plans\Add',
        'admin.projects' => '\Admin\Projects\Add',
        'admin.teams' => '\Admin\Teams\Add',
        'admin.writers' => '\Admin\Writers\Add',
        /*client*/
        'client.projects' => '\Client\Projects\Add',
    ];

    /**
     * @var array
     */
    protected $actions = [
        'main',
        'add',
        'edit',
        'single',
    ];

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
        View::composer('partials.left-sidebar', LeftMenuComposer::class);

        //$this->compose();
    }

    /**
     * Run all view composers
     */
    private function compose()
    {
        foreach ($this->collections as $view => $composer) {
            View::composer("{$this->pages_path}.{$view}.main", $this->composers_path.$composer);
            unset($view, $composer);
        }

        foreach ($this->singles as $view => $composer) {
            View::composer("{$this->pages_path}.{$view}.single", $this->composers_path.$composer);
            unset($view, $composer);
        }

        foreach ($this->edits as $view => $composer) {
            View::composer("{$this->pages_path}.{$view}.edit", $this->composers_path.$composer);
            unset($view, $composer);
        }

        foreach ($this->adds as $view => $composer) {
            View::composer("{$this->pages_path}.{$view}.add", $this->composers_path.$composer);
            unset($view, $composer);
        }

       /* View::composer(
            "{$this->pages_path}.client.projects.*",
            $this->composers_path.'\Client\Projects\Add'
            );*/

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