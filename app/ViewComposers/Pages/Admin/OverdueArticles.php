<?php
/**
 * Created by PhpStorm.
 * User: imad
 * Date: 1/29/18
 * Time: 3:01 PM
 */

namespace App\ViewComposers\Pages\Admin;


use App\Models\Article;
use App\Models\Role;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Class OverdueArticles
 * @package App\ViewComposers\Pages\Admin
 */
class OverdueArticles
{

    /**
     * @var Request
     */
    protected $request;

    /**
     * OverdueArticles constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     *
     */
    public function compose(View $view)
    {
        $overdue = $this->request->input('overdue');

        if (Auth::user()->role == Role::ADMIN) {
            $query = Article::new();
        } else {
            $query = Auth::user()->articles()->new();
        }

        if ($this->request->has('customer') and $this->request->input('customer') > 0) {
            $user = User::search($this->request->input('customer'))->first();
            if ($user) {
                $client_id = $user->id;
                $query->whereHas('project', function ($query) use ($client_id) {
                    $query->where('client_id', $client_id);
                });
            }
        }


        switch ($overdue) {
            case 1: // not overdue
                $query->whereBetween('updated_at', [Carbon::now()->subDay(1), Carbon::now()]);
                break;
            case 2: // 2 days overdue
                $query->whereBetween('updated_at', [Carbon::now()->subDay(2), Carbon::now()->subDay(1)]);
                break;
            case 3: // 3 days overdue
                $query->whereBetween('updated_at', [0, Carbon::now()->subDay(2)]);
                break;
        }

        $articles       = $query->take(10)->get();
        $articles_count = $query->count();

        return $view->with(compact('articles', 'articles_count'));


        return $view->with(compact(''));
    }

}