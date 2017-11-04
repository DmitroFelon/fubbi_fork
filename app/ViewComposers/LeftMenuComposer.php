<?php
/**
 * Created by PhpStorm.
 * User: imad
 * Date: 02/11/17
 * Time: 17:52
 */

namespace App\ViewComposers;

use App\Models\Role;
use Illuminate\Foundation\Auth\User;
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

    protected $user;

    /**
     * LeftMenuComposer constructor.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(Request $request)
    {
        $this->user = Auth::user();
        $this->request = $request;
    }

    /**
     * @param \Illuminate\View\View $view
     */
    public function compose(View $view)
    {
        $this->page = $this->request->path();

        $links = [];

        if(!is_null($this->user)){
            foreach (Role::$roles as $role) {
                if ($this->user->hasRole($role)) {
                    $links = $this->{$role}();
                    break;
                }
            }
        }else{
            $links = $this->guest();
        }

        $view->with('items', $links);
    }

    /**
     * @return array
     */
    public function admin()
    {
        switch ($this->page) {
            case 'clients':
            case 'clients/add':
                return [
                    'All clients' => '/clients',
                    'Add client' => '/clients/add',
                ];
                break;
            case 'writers':
            case 'writers/add':
                return [
                    'All writers' => '/writers',
                    'Add writer' => '/writers/add',
                ];
                break;
            case 'designers':
            case 'designers/add':
                return [
                    'All designers' => '/designers',
                    'Add designer' => '/designers/add',
                ];
                break;
            case 'managers':
            case 'managers/add':
                return [
                    'All managers' => '/managers',
                    'Add manager' => '/managers/add',
                ];
                break;
            case 'teams':
            case 'teams/add':
                return [
                    'All teams' => '/teams',
                    'Add team' => '/teams/add',
                ];
                break;
            case 'projects':
            case 'projects/add':
                return [
                    'All projects' => '/projects',
                    'Add project' => '/projects/add',
                ];
                break;
            case 'plans':
            case 'plans/add':
                return [
                    'All plans' => '/plans',
                    'Add plan' => '/plans/add',
                ];
                break;
            case 'settings':
                return [
                    'Account' => '/settings',
                ];
                break;
            default:
                return [
                    'test' => 'test',
                ];
        }
    }

    /**
     * @return array
     */
    public function client()
    {
        return [
            'Onboarding Quiz' => 'onboarding_quiz',
            'Keywords' => 'keywords',
            'Article Topics' => 'article_topics',
            'Article Outlines' => 'article_outlines',
            'Articles' => 'articles',
            'Social Post Text' => 'social_post_text',
            'Social Post Design' => 'social_post_design',
            'Quora' => 'quora',
            'LinkedIn' => 'linkedin',
            'Medium' => 'medium',
            'Marketing Calendar' => 'marketing_calendar',
        ];
    }

    /**
     * @return array
     */
    public function account_manager()
    {
        return [

        ];
    }

    /**
     * @return array
     */
    public function writer()
    {
        return [

        ];
    }

    /**
     * @return array
     */
    public function editor()
    {
        return [

        ];
    }

    /**
     * @return array
     */
    public function designer()
    {
        return [

        ];
    }

    public function guest()
    {
        return [
            'Login' => '/login',
            'Register' => '/register',
        ];
    }
}