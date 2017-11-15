<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProject;
use App\Models\Article;
use App\Models\Keyword;
use App\Models\Plan;
use App\Models\Project;
use Illuminate\Http\Request;
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
	public function store(StoreProject $request)
	{
		 
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
		abort_if($project->client_id != $this->request->user()->id, 404);

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
	 * @param  \Illuminate\Http\Request $request
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(StoreProject $request, $id)
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
}
