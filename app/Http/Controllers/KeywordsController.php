<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Services\Api\KeywordTool;

class KeywordsController extends Controller
{
	public function index(Project $project, string $theme)
	{
		$keywords = [];

		//TODO store data from KeywordTool in meta data

		for ($i = 0; $i < 11; $i++) {
			$keywords["keyword - {$i}"] = true;
		}

		try {
			$api      = new KeywordTool();
			$result   = collect();
			$response = $api->suggestions(trim($theme));

			if (! isset($response[$theme])) {
				return view(
					'entity.project.partials.form.keywords-step',
					[
						'project'  => $project,
						'keywords' => $keywords,
						'theme'    => $theme,
					]
				);
			}

			$response       = collect($response[$theme]);
			$result[$theme] = collect($response->pluck('string'));

			return view(
				'entity.project.partials.form.keywords-step',
				[
					'project'  => $project,
					'keywords' => $keywords,
					'theme'    => $theme,
				]
			);
		} catch (\Exception $e) {
			return view(
				'entity.project.partials.form.keywords-step',
				[
					'project'  => $project,
					'keywords' => $keywords,
					'theme'    => $theme,
				]
			);
		}
	}
}
