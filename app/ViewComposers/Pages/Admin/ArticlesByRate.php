<?php
/**
 * Created by PhpStorm.
 * User: imad
 * Date: 1/27/18
 * Time: 9:43 AM
 */

namespace App\ViewComposers\Pages\Admin;


use App\Models\Article;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArticlesByRate
{

    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function compose(View $view)
    {

        $rate  = $this->request->input('rate');
        $query = Article::withRating($rate, ($rate == 3) ? '<=' : '=');

        if ($this->request->has('customer') and $this->request->input('customer') != '') {
            $user = User::search($this->request->input('customer'))->first();
            if ($user) {
                $query->whereHas('project', function ($query) use ($user) {
                    $query->where('client_id', $user->id);
                });
            }
        }

        if ($this->request->has('date_from')) {
            $from = Carbon::createFromFormat('m/d/Y', $this->request->input('date_from'));
            $query->where('created_at', '>', $from);
        }

        if ($this->request->has('date_to')) {
            $to = Carbon::createFromFormat('m/d/Y', $this->request->input('date_to'));
            $query->where('created_at', '<', $to);
        }

        $articles       = $query->take(10)->get();
        
        $articles_count = $query->count();

        return $view->with(compact('articles', 'articles_count'));


    }

}