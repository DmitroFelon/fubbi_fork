<?php
/**
 * Created by PhpStorm.
 * User: imad
 * Date: 02/11/17
 * Time: 17:44
 */

namespace App\ViewComposers;


use Illuminate\View\View;

class TopMenuComposer
{
    public function compose(View $view)
    {
        $view->with('items', [
                'url1' => 'name1',
                'url2' => 'name2',
                'url3' => 'name3',
                'url4' => 'name4',
                'url5' => 'name5',
                'url6' => 'name6',
                'url7' => 'name7',
                'url8' => 'name8',
            ]
        );
    }
}