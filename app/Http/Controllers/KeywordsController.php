<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Services\Api\KeywordTool;
use Illuminate\Support\Facades\Session;

class KeywordsController extends Controller
{
	public function index(Project $project, string $theme)
	{
		try {
			$keywords_full = ($project->getMeta('keywords')) ? collect($project->getMeta('keywords')) : collect();

			if ($keywords_full->has($theme) and ! empty($keywords_full->get($theme))) {
				$keywords = $keywords_full->get($theme);
			} else {

				echo 'before api call'."<br>";

				$api      = new KeywordTool();

				$response = $api->suggestions($theme);

				echo 'after api call'."<br>";

				$response = collect($response->get('results'));

				$response = collect($response->get($theme));

				Session::put('keywords', $response);

				echo 'before transform'."<br>";

				$keywords = collect($response->keyBy('string'))->transform(
					function ($item, $key) {
						return false;
					}
				);

				echo 'after transform'."<br>";

				$keywords_full->put($theme, $keywords->toArray());

				echo 'before dd'."<br>";

				dd($keywords, $keywords_full);

				//$project->setMeta('keywords', $keywords_full);

				//$project->save();
			}

			$data = compact(
				[
					'project',
					'keywords',
					'theme',
				]
			);

			return view('entity.project.partials.form.keywords-step', $data);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}
}
