<?php
/**
 * Created by PhpStorm.
 * User: imad
 * Date: 02/11/17
 * Time: 17:52
 */

namespace App\ViewComposers;


use Illuminate\View\View;

class LeftMenuComposer
{
    public function compose(View $view)
    {
        $view->with('items', [
                'side_url1' => 'name1',
                'side_url2' => 'name2',
                'side_url3' => 'name3',
                'side_url4' => 'name4',
                'side_url5' => 'name5',
                'side_url6' => 'name6',
                'side_url7' => 'name7',
                'side_url8' => 'name8',
            ]
        );
    }
}