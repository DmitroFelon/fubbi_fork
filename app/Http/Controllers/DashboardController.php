<?php
/**
 * Created by PhpStorm.
 * User: imad
 * Date: 03/11/17
 * Time: 12:00
 */

namespace App\Http\Controllers;

use App\Models\Role;
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
     * @var \App\User
     */
    protected $user;

    /**
     * @var \App\Models\Role
     */
    protected $role;

    /**
     * DashboardController constructor.
     *
     */
    public function __construct()
    {
        /*Auth::logout();

        $this->user = Auth::user();

        foreach (Role::$roles as $role) {
            if ($this->user->hasRole($role)) {
                $this->role = $role;
                break;
            }
        }*/
    }

    /**
     * @param string $page
     * @return \Illuminate\Support\Facades\View|null
     */
    public function index($page = 'home')
    {
        $page = str_replace('/', '.', $page);


        //admin for test
        if (View::exists("pages.admin.{$page}")) {
            return view("pages.admin.{$page}");
        }

        abort(404);

        return null;
    }
}