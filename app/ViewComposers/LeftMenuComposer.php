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
        $this->page = $request->path();
    }

    /**
     * @param \Illuminate\View\View $view
     */
    public function compose(View $view)
    {

        if (Auth::check()) {
            $role = $this->user->getRole();
            $links = $this->{$role}();
        } else {
            $links = $this->guest();
        }

        $view->with('items', $links);
    }

    public function guest()
    {
        return [
            'Login' => '/login',
            'Register' => '/register',
        ];
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
}