<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Jobs\GoogleDriveCreate;
use App\Jobs\GoogleDriveUpload;
use App\Models\Article;
use App\Models\Project;
use App\Services\Google\Drive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\MediaLibrary\Media;

/**
 * Class ArticlesController
 * @package App\Http\Controllers\Project
 */
class ArticlesController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:articles.index,project')->only(['index']);
        $this->middleware('can:articles.update,project,article')->only(['edit', 'save_social_posts']);
        $this->middleware('can:articles.create,project,App\Models\Article')->only(['create', 'store']);
        $this->middleware('can:articles.delete,project,article')->only(['destroy']);
        $this->middleware('can:articles.accept,project,article')->only(['accept', 'decline']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param \App\Models\Project $project
     * @param Article $article
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Project $project, Article $article, Request $request)
    {
        $articles_query = $project->articles();

        if ($request->has('type') and $request->input('type') != '') {
            $articles_query->where('type', $request->input('type'));
        }

        if ($request->has('status') and $request->input('status') != '') {
            if ($request->input('status') == 1) {
                $articles_query->accepted();
            } else {
                $articles_query->declined();
            }
        }

        $articles = $articles_query->simplePaginate(10);

        $filters['types'] = $article->getTypes($project);

        $filters['statuses'] = [
            ''    => _i('Select status'),
            true  => _i('Accepted'),
            false => _i('Declined')
        ];

        return view('entity.article.index', compact('project', 'articles', 'filters'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Project $project, Article $article)
    {

        $filters['types'] = $article->getTypes($project);

        return view('entity.article.create', compact('project', 'filters'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Models\Project $project
     * @param \App\Models\Article $article
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileDoesNotExist
     * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileIsTooBig
     * @internal param Drive $google
     */
    public function store(Project $project, Article $article, Drive $drive, Request $request)
    {

        //save article
        $article->fill(
            $request->except(['_token', '_method'])
        );

        $article->user_id = Auth::user()->id;

        $article->setMeta('type', $request->input('type'));

        $article->save();

        $project->attachArticle($article->id);

        //attach tags
        $tags = collect(explode(',', $request->input('tags')));

        $tags->each(function ($tag) use ($article) {
            $article->attachTagsHelper($tag);
        });

        //upload file to google docs
        if ($request->hasFile('file')) {
            $file      = $article->addMedia($request->file('file'))->toMediaCollection('file');
            $file_name = ($article->title) ? $article->title : $request->file('file')->getClientOriginalName();
            GoogleDriveUpload::dispatch($project, $article, $file, $file_name);
        } else {
            $file_name = ($article->title) ? $article->title : $project->name . '-' . rand();
            GoogleDriveCreate::dispatch($project, $article, $file_name);
        }

        //upload copyscape screenshot
        if ($request->hasFile('copyscape')) {
            $article->addMedia($request->file('copyscape'))->toMediaCollection('copyscape');
        }

        return redirect()->action('Project\ArticlesController@index', $project);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Project $project
     * @param  \App\Models\Article $article
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project, Article $article)
    {
        $article = $project->articles()->findOrFail($article->id);

        return view('entity.article.show', compact('project', 'article'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Project $project
     * @param  \App\Models\Article $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project, Article $article)
    {
        $article = $project->articles()->findOrFail($article->id);

        return view('entity.article.edit', compact('project', 'article'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Project $project
     * @param  \App\Models\Article $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project, Article $article)
    {
        $article->delete();
        return redirect()->action('Project\ArticlesController@index', $project);
    }

    public function save_social_posts(Project $project, Article $article, Request $request)
    {

        $article = $project->articles()->findOrFail($article->id);

        $article->setMeta('socialposts', $request->input('socialposts'));

        $article->type = $request->input('type');


        $tags = collect(explode(',', $request->input('tags')));

        $article->syncTags([]);

        $tags->each(function ($tag) use ($article) {
            $article->attachTagsHelper($tag);
        });

        $article->save();

        return redirect()->back()->with('success', _i('Article updated'));
    }

    /**
     * @param Project $project
     * @param Article $article
     * @return \Illuminate\Http\RedirectResponse
     */
    public function accept(Project $project, Article $article)
    {
        $project->acceptArticle($article->id);
        return redirect()->action('Project\ArticlesController@index', $project);
    }

    /**
     * @param Project $project
     * @param Article $article
     * @return \Illuminate\Http\RedirectResponse
     */
    public function decline(Project $project, Article $article)
    {
        $project->declineArticle($article->id);
        return redirect()->action('Project\ArticlesController@index', $project);
    }
}
