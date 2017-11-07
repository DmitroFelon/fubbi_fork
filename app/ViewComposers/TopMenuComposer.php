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
     * @var \Illuminate\Contracts\Auth\Authenticatable|null
     */
    protected $user;

    /**
     * @var string
     */
    protected $page;
    /**
     * TopMenuComposer constructor.
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

        if(Auth::check()){
            $role = $this->user->getRole();
            $links = $this->{$role}();
        }else{
            $links = $this->guest();
        }


        $view->with('items', $links);
    }

    /**
     * @return array
     */
    public function guest()
    {
        return [];
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
            'Projects' => '/projects',
            'Alerts' => '/alerts',
            'Chat' => '/chat',
            'Book a call' => '/book_a_call',
            'FAQ' => '/fuq',
            'Settings' => '/settings',

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