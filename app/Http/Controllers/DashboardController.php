<?php
/**
 * Created by PhpStorm.
 * User: imad
 * Date: 03/11/17
 * Time: 12:00
 */

namespace App\Http\Controllers;


use Illuminate\Support\Facades\View;

class DashboardController extends Controller
{


    public function index($page = 'home')
    {
        if (View::exists("pages.{$page}")) {
            return view("pages.{$page}");
        }
        abort(404);
        return null;
    }

}