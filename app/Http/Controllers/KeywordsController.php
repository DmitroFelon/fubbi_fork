<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Services\Api\KeywordTool;

class KeywordsController extends Controller
{
	public function index(Project $project, string $theme)
	{
		$keywords = [];

		for ($i = 0; $i < 11; $i++) {
			$keywords[] = [
				'text'     => "keyword - {$i}",
				'accepted' => true,
				'theme'    => $theme,
			];
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
					]
				);
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
			return view(
				'entity.project.partials.form.keywords-step',
				[
					'project'  => $project,
					'keywords' => $keywords,
				]
			);
		}
	}
}
