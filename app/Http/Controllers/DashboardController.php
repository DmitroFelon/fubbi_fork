<?php
/**
 * Created by PhpStorm.
 * User: imad
 * Date: 03/11/17
 * Time: 12:00
 */

namespace App\Http\Controllers;

use App\Models\Role;
use App\Services\FlashMessage;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

/**
 * Class DashboardController
 *
 * @package App\Http\Controllers
 */
class DashboardController extends Controller
{

    /**
     * @var Request
     */
    protected $request;

    /**
     * DashboardController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param string $page
     * @param string $action
     * @return \Illuminate\Support\Facades\View|null
     */
    public function index($page = 'home', $action = 'main', $id = null)
    {
        $user = Auth::user();

        $role = $user->role;

        if ($page == 'home') {
            //set dynamic home page by role
            $redirect = $this->composeRedirect();
            if ($redirect) {
                return $redirect;
            }
        }

        $action = (isset($action)) ? '.' . $action : '';

        if (View::exists("pages.{$role}.{$page}{$action}")) {
            return view("pages.{$role}.{$page}{$action}");
        }

        return abort(404);
    }


    /**
     * @return null
     */
    private function composeRedirect()
    {
        $user = Auth::user();
        $role = $user->role;

        switch ($role) {
            case 'client':
                return $this->client();
                break;
            case 'admin':
                return $this->admin();
                break;
            case 'account_manager':
                break;
            case 'researcher':
                break;
            case 'writer':
                return $this->admin();
                break;
            case 'designer':
                break;
            default:
                return null;

        }


    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    private function client()
    {
        $user = Auth::user();
        $role = $user->role;
        if ($user->projects()->count() == 1) {
            return redirect()->action("ProjectController@show", $user->projects()->first());
        } elseif ($user->projects()->count() > 1) {
            return redirect()->action("ProjectController@index");
        } else {
            return redirect()->action("ProjectController@create");
        }
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    private function admin()
    {
        return redirect()->action("ProjectController@index");
    }
}