<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProject;
use App\Models\Article;
use App\Models\Keyword;
use App\Models\Plan;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;

class ProjectController extends Controller
{
	protected $request;

	public function __construct(Request $request)
	{
		$this->request = $request;
		$this->authorizeResource(Project::class);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		switch ($this->request->user()->getRole()) {
			case 'admin':
				$projects = Project::all();
				break;
			default:
				$projects = $this->request->user()->projects()->get();
				break;
		}

		return view('pages.'.$this->request->user()->getRole().'.projects.index', ['projects' => $projects]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$data = [
			'keywords' => Keyword::all()->toArray(),
			'plans'    => Plan::all(),
			'articles' => Article::all(),
		];

		return view('pages.'.$this->request->user()->getRole().'.projects.create', $data);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(StoreProject $request, Project $project)
	{
		$project->client_id = Auth::user()->id;

		$project->setState(Project::CREATED);

		$project->setMeta($request->except(['_token']));

		foreach ($request->file('article_images') as $file){
			$project->addMedia($file)->toMediaCollection('article_images');
		}
		foreach ($request->file('compliance_guideline') as $file){
			$project->addMedia($file)->toMediaCollection('compliance_guideline');
		}
		foreach ($request->file('logo') as $file){
			$project->addMedia($file)->toMediaCollection('logo');
		}
		foreach ($request->file('ready_content') as $file){
			$project->addMedia($file)->toMediaCollection('ready_content');
		}

		$project->save();

		return redirect()->action('ProjectController@index');

	}

	/**
	 * Display the specified resource.
	 *
	 * @param \App\Models\Project $project
	 * @return \Illuminate\Http\Response
	 */
	public function show(Project $project)
	{
		return view('pages.'.$this->request->user()->getRole().'.projects.show', ['project' => $project]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param \App\Models\Project $project
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Project $project)
	{
		$data = [
			'keywords' => Keyword::all()->toArray(),
			'plans'    => Plan::all(),
			'articles' => Article::all(),
			'project'  => $project,
		];
		return view('pages.'.$this->request->user()->getRole().'.projects.edit', $data);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param \App\Http\Requests\StoreProject|\Illuminate\Http\Request $request
	 * @param \App\Models\Project $project
	 * @return \Illuminate\Http\Response
	 */
	public function update(StoreProject $request, Project $project)
	{
		$project->setMeta($request->except(['_token']));

		$project->save();

		return redirect()->action('ProjectController@index');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		return redirect()->action('ProjectController@index');
	}
}
