<?php
/**
 * Created by PhpStorm.
 * User: imad
 * Date: 02/11/17
 * Time: 17:52
 */

namespace App\ViewComposers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Class LeftMenuComposer
 *
 * @package App\ViewComposers
 */
class LeftMenuComposer
{
    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * @var string
     */
    protected $page;

    /**
     * @var \Illuminate\Contracts\Auth\Authenticatable|null
     */
    protected $user;

    /**
     * LeftMenuComposer constructor.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(Request $request)
    {
        $this->user    = Auth::user();
        $this->request = $request;
        $this->page    = $request->path();
    }

    /**
     * @param \Illuminate\View\View $view
     */
    public function compose(View $view)
    {

        if (Auth::check()) {
            $role  = $this->user->role;
            $links = $this->{$role}();
        } else {
            $links = $this->guest();
        }

        $links = collect($links)->push(
            [
                'name' => 'Messages',
                'url'  => action('MessageController@index'),
                'icon' => 'fa fa-envelope',
            ]
        );

        $links = collect($links)->push(
            [
                'name' => 'Settings',
                'url'  => action('SettingsController@index'),
                'icon' => 'fa fa-gear',
            ]
        );

        $links = collect($links)->push(
            [
                'name' => 'Issues',
                'url'  => action('IssueController@index'),
                'icon' => 'fa fa-bug',
            ]
        );


        $view->with('items', $links);
    }

    /**
     * @return array
     */
    public function guest()
    {
        return [
            'Login'    => action('Auth\LoginController@login'),
            'Register' => action('Auth\RegisterController@register'),
        ];
    }

    /**
     * @return array
     */
    public function admin()
    {
        return [
            [
                'name' => 'Users',
                'url'  => action('UserController@index'),
                'icon' => 'fa fa-user',
            ],
            [
                'name' => 'Teams',
                'url'  => action('TeamController@index'),
                'icon' => 'fa fa-users',
            ],
            [
                'name' => 'Projects',
                'url'  => action('ProjectController@index'),
                'icon' => 'fa fa-file-o',
            ],
            [
                'name' => 'Plans',
                'url'  => action('PlanController@index'),
                'icon' => 'fa fa-gear',
            ],
            [
                'name' => 'Articles',
                'url'  => action('ArticlesController@index'),
                'icon' => 'fa fa-file-word-o',
            ],
            [
                'name' => 'Charges',
                'url'  => action('ChargesController@index'),
                'icon' => 'fa fa-dollar',
            ],
        ];
    }

    /**
     * @return array
     */
    public function client()
    {
        return [
            [
                'name' => 'Projects',
                'url'  => action('ProjectController@index'),
                'icon' => 'fa fa-file-o',
            ],
        ];
    }

    /**
     * @return array
     */
    public function account_manager()
    {
        return [
            [
                'name' => 'Teams',
                'url'  => action('TeamController@index'),
                'icon' => 'fa fa-users',
            ],
            [
                'name' => 'Projects',
                'url'  => action('ProjectController@index'),
                'icon' => 'fa fa-file-o',
            ],
        ];
    }

    /**
     * @return array
     */
    public function writer()
    {
        return [
            [
                'name' => 'Teams',
                'url'  => action('TeamController@index'),
                'icon' => 'fa fa-users',
            ],
            [
                'name' => 'Projects',
                'url'  => action('ProjectController@index'),
                'icon' => 'fa fa-file-o',
            ],
        ];
    }

    /**
     * @return array
     */
    public function editor()
    {
        return [
            [
                'name' => 'Teams',
                'url'  => action('TeamController@index'),
                'icon' => 'fa fa-users',
            ],
            [
                'name' => 'Projects',
                'url'  => action('ProjectController@index'),
                'icon' => 'fa fa-file-o',
            ],
        ];
    }

    /**
     * @return array
     */
    public function designer()
    {
        return [
            [
                'name' => 'Teams',
                'url'  => action('TeamController@index'),
                'icon' => 'fa fa-users',
            ],
            [
                'name' => 'Projects',
                'url'  => action('ProjectController@index'),
                'icon' => 'fa fa-file-o',
            ],
        ];
    }

    public function researcher()
    {
        return [
            [
                'name' => 'Teams',
                'url'  => action('TeamController@index'),
                'icon' => 'fa fa-users',
            ],
            [
                'name' => 'Projects',
                'url'  => action('ProjectController@index'),
                'icon' => 'fa fa-file-o',
            ],
        ];
    }
}