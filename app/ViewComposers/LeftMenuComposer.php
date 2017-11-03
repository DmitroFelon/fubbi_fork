<?php
/**
 * Created by PhpStorm.
 * User: imad
 * Date: 02/11/17
 * Time: 17:52
 */

namespace App\ViewComposers;

use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LeftMenuComposer
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