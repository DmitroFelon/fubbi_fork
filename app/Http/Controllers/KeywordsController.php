<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Services\Api\KeywordTool;

class KeywordsController extends Controller
{
	public function index(Project $project, string $theme)
	{

		try {
			$api      = new KeywordTool();
			$result   = collect();
			$response = $api->suggestions(trim($theme));
			

			if(!isset($response[$theme])){
				return \GuzzleHttp\json_encode($response);
			}

			$response       = collect($response[$theme]);
			$result[$theme] = collect($response->pluck('string'));

			return view(
				'entity.project.partials.form.keywords-step',
				[
					'project'  => $project,
					'keywords' => $result,
				]
			);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}
}
