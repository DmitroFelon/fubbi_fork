<?php
/**
 * Created by PhpStorm.
 * User: imad
 * Date: 02/11/17
 * Time: 17:44
 */

namespace App\ViewComposers;


use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TopMenuComposer
{
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

    public function admin()
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
            'settings' => 'settings',

        ];
    }

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
            'settings' => 'settings',

        ];
    }

    public function account_manager()
    {
        return [

        ];
    }

    public function writer()
    {
        return [

        ];
    }

    public function editor()
    {
        return [

        ];
    }

    public function designer()
    {
        return [

        ];
    }
}