<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Services\Google\Drive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticlesController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:index,' . Article::class)->only(['index']);
        $this->middleware('can:show,article')->only(['show']);
        $this->middleware('can:update,article')->only(['update', 'edit']);
        $this->middleware('can:create,' . Article::class)->only(['create', 'store']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $all = true;

        $articles_query = Article::query();

        if ($request->has('type') and $request->input('type') != '') {
            $articles_query->where('type', $request->input('type'));
        }

        $articles = $articles_query->simplePaginate(10);

        $filters['types'] = Article::getAllTypes();

        $filters['statuses'] = [
            ''    => _i('Select status'),
            true  => _i('Accepted'),
            false => _i('Declined')
        ];

        return view('entity.article.index', compact('articles', 'all', 'filters'));
    }

    /**
     * Display the specified resource.
     *
     * @param Article $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        return view('entity.article.show', compact('article'));
    }

    public function request_access(Article $article, Request $request, Drive $drive)
    {

        $email     = Auth::user()->email;
        $google_id = $article->google_id;

        $permissions = [$email => 'commenter'];
        $drive->addPermission($google_id, $permissions);
        return redirect()->back()->with('success', 'Permissions has been provided');
    }
}
