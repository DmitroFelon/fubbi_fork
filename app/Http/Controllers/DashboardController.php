<?php
/**
 * Created by PhpStorm.
 * User: imad
 * Date: 03/11/17
 * Time: 12:00
 */

namespace App\Http\Controllers;

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
    }

    /**
     * @param string $page
     * @param string $action
     * @return \Illuminate\Support\Facades\View|null
     */
    public function index($page = 'home', $action = 'main')
    {
        $action = (isset($action)) ? '.'.$action : '';

        //admin for test
        if (View::exists("pages.admin.{$page}{$action}")) {
            return view("pages.admin.{$page}{$action}");
        }

        abort(404);

        return null;
    }
}