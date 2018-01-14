<?php
/**
 * Created by PhpStorm.
 * User: imad
 * Date: 1/13/18
 * Time: 3:33 PM
 */

namespace App\ViewComposers\Pages\Admin;


use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class LastArticlesComposer
{

    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    
    public function compose(View $view)
    {
        $last_articles       = Article::new()->take(10)->get();
        $last_articles_count = Article::new()->count();

        return $view->with(compact('last_articles', 'last_articles_count'));
    }
}