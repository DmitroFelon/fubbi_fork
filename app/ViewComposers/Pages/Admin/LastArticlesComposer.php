<?php
/**
 * Created by PhpStorm.
 * User: imad
 * Date: 1/13/18
 * Time: 3:33 PM
 */

namespace App\ViewComposers\Pages\Admin;


use App\Models\Article;
use Carbon\Carbon;
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
        $query = Article::new();

        if ($this->request->has('customer') and $this->request->input('customer') > 0) {
            $client_id = $this->request->input('customer');
            $query->whereHas('project', function ($query) use ($client_id) {
                $query->where('client_id', $client_id);
            });
        }

        if ($this->request->has('date_from')) {
            $from = Carbon::createFromFormat('m/d/Y', $this->request->input('date_from'));
            $query->where('created_at', '>', $from);
        }

        if ($this->request->has('date_to')) {
            $to = Carbon::createFromFormat('m/d/Y', $this->request->input('date_to'));
            $query->where('created_at', '<', $to);
        }

        $last_articles       = $query->take(10)->get();
        $last_articles_count = $query->count();

        return $view->with(compact('last_articles', 'last_articles_count'));
    }
}