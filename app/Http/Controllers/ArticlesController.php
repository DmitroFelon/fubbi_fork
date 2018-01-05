<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Services\Google\Drive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticlesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'articles' => Article::paginate(),
            'all'      => true
        ];

        return view('entity.article.index', $data);
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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
