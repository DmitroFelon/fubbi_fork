<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Jobs\GoogleDriveUpload;
use App\Models\Article;
use App\Models\Project;
use App\Services\Google\Drive;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
        return view('entity.article.index', ['project' => $project]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Project $project)
    {
        return view('entity.article.create', ['project' => $project]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Models\Project $project
     * @param \App\Models\Article $article
     * @param  \Illuminate\Http\Request $request
     * @param Drive $google
     * @return \Illuminate\Http\Response
     */
    public function store(Project $project, Article $article, Request $request)
    {

        if ($request->hasFile('file')) {
            $file = $article->addMedia('file')->toMediaCollection('file');
            $file->getPath();

            GoogleDriveUpload::dispatch($project, $file);
            

        }

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
        return view('entity.article.show');
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
        return view('entity.article.edit');
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
        //
    }
}
