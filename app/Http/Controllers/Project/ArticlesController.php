<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Jobs\GoogleDriveUpload;
use App\Models\Article;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\Media;

/**
 * Class ArticlesController
 * @package App\Http\Controllers\Project
 */
class ArticlesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \App\Models\Project $project
     * @return \Illuminate\Http\Response
     */
    public function index(Project $project)
    {
        return view('entity.article.index', compact('project'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Project $project)
    {
        return view('entity.article.create', compact('project'));
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
    public function store(Project $project, Article $article, Request $request)
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
     * Update the specified resource in storage.
     *
     * @param \App\Models\Project $project
     * @param  \App\Models\Article $article
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Project $project, Article $article, Request $request)
    {
        //
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
