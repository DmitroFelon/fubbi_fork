<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProject;
use App\Models\Article;
use App\Models\Keyword;
use App\Models\Plan;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;

/**
 * Class ProjectController
 *
 * @package App\Http\Controllers
 */
class ProjectController extends Controller
{
	/**
	 * @var \Illuminate\Http\Request
	 */
	protected $request;

	/**
	 * ProjectController constructor.
	 *
	 * @param \Illuminate\Http\Request $request
	 */
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
	public function create(Request $request)
	{
		$step = ($request->input('step') != null) ? $request->input('step') : 'plan';

		$plans = Cache::remember('plans', 60, function (){
			return \Stripe\Plan::all();
		});

		return view('pages.'.$this->request->user()->getRole().'.projects.create', [
			'keywords' => Keyword::all()->toArray(),
			'plans'    => $plans->data,
			'articles' => Article::all(),
			'step'     => $step,
		]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param \App\Http\Requests\StoreProject|\Illuminate\Http\Request $request
	 * @param \App\Models\Project $project
	 * @return \Illuminate\Http\Response
	 * @throws \Exception
	 * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileDoesNotExist
	 * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileIsTooBig
	 */
	public function store(StoreProject $request, Project $project)
	{
		$subscription = session('subscription');

		$plan = $subscription->stripe_plan;

		$task = config('fubbi.plans');

		$project->client_id = Auth::user()->id;

		$project->setState(Project::CREATED);

		$project->setMeta($request->except(['_token']));

		$project->addFiles($request);

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
		return view('pages.'.$this->request->user()->getRole().'.projects.edit', [
			'keywords' => Keyword::all()->toArray(),
			'plans'    => Plan::all(),
			'articles' => Article::all(),
			'project'  => $project,
		]);
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
