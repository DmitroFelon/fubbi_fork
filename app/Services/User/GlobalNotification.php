<?php
/**
 * Created by PhpStorm.
 * User: imad
 * Date: 2/8/18
 * Time: 2:04 PM
 */

namespace App\Services\User;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class GlobalNotification
{
    public function make()
    {
        if (!Auth::check()) {
            return;
        }
        $role = Auth::user()->role;
        if (method_exists($this, $role)) {
            call_user_func([$this, $role]);
        }

    }


    private function client()
    {

    }

    private function admin()
    {
        Session::remove('info');
        Session::flash('info', 'admin1');
        Session::flash('success', 'admin2');
        Session::flash('error', 'admin3');


        //dd(Session::pull('info'), Session::get('info'));
    }

    private function account_manager()
    {

    }

    private function writer()
    {

    }

    private function designer()
    {

    }

    private function editor()
    {

    }

    private function researcher()
    {

    }

}