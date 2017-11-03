<?php
/**
 * Created by PhpStorm.
 * User: imad
 * Date: 02/11/17
 * Time: 17:44
 */

namespace App\ViewComposers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Class TopMenuComposer
 *
 * @package App\ViewComposers
 */
class TopMenuComposer
{
    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * TopMenuComposer constructor.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param \Illuminate\View\View $view
     */
    public function compose(View $view)
    {
        $links = [];

        foreach (Role::$roles as $role) {
            if (Auth::user()->hasRole($role)) {
                $links = $this->{$role}();
                break;
            }
        }

        $view->with('items', $links);
    }

    /**
     * @return array
     */
    public function admin()
    {
        return [
            'Dashboard' => '/',
            'Clients' => '/clients',
            'Writers' => '/writers',
            'Designers' => '/designers',
            'Managers' => '/managers',
            'Teams' => '/teams',
            'Projects' => '/projects',
            'Plans' => '/plans',
            'Settings' => '/settings',

        ];
    }

    /**
     * @return array
     */
    public function client()
    {
        return [
            'Dashboard' => 'home',
            'Plan' => 'plan',
            'Alerts' => 'alerts',
            'Content Checklist' => 'content_checklist',
            'Design Checklist' => 'design_checklist',
            'Chat' => 'chat',
            'Book a call' => 'book a call',
            'FAQ' => 'fuq',
            'Settings' => 'settings',

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