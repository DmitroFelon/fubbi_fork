<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

/**
 * Adds modigicators to project's plan services
 *
 * Class PlanController
 *
 * @package App\Http\Controllers\Project
 */
class PlanController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Project $project)
	{
		return $project->plan->id;
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param \App\Models\Project $project
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Project $project, $id = null)
	{
		$data = $this->output($project);
		
		return view('entity.plan.project.edit', $data);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param \App\Models\Project $project
	 * @param  int $id
	 * @param  \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function update(Project $project, $id, Request $request)
	{
		$plan = $project->plan;

		$plan->metadata = collect($plan->metadata);

		$input_metadata = collect($request->except(['_method', '_token']));

		$diff = $plan->metadata->diffAssoc($input_metadata);

		$diff->each(function ($item, $key) use ($project){
			$project->modify($key, $item);
		});

		$data = $this->output($project);

		return view('entity.plan.project.edit', $data);
	}

	private function output (Project $project) {
		$plan = $project->plan;
		
		$plan->metadata = collect($plan->metadata);
		
		$plan->metadata->transform(function ($item, $key) use ($project){
			return ($project->isModified($key))
				?$project->getModified($key)
				:$item;
		});
		
		return [
			'plan'    => $plan,
			'project' => $project,
		];
	}
}
