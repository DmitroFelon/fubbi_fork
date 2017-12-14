<?php
/**
 * Created by PhpStorm.
 * User: imad
 * Date: 09/11/17
 * Time: 12:33
 */

namespace App\Models\Traits\Project;

use App\Exceptions\Project\ImpossibleProjectState;
use App\Models\Helpers\ProjectStates;
use App\Models\Keyword;
use App\Services\Api\KeywordTool;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;

/**
 * Class hasStates
 *
 * @package App\Models\Traits\Project
 */
trait hasStates
{
	/**
	 * @return bool
	 */
	public function isOnReview()
	{
		$reviewable_states = [
			ProjectStates::MANAGER_REVIEW,
		];

		return in_array($this->state, $reviewable_states);
	}

	/**
	 * @param \Illuminate\Http\Request $request
	 * @return $this
	 */
	public function filling(Request $request)
	{
		switch ($request->input('_step')) {
			case \App\Models\Helpers\ProjectStates::QUIZ_FILLING:
				$this->fillQuiz($request);
				break;
			case \App\Models\Helpers\ProjectStates::KEYWORDS_FILLING:
				$this->fillKeywords($request);
				break;
			default:
				abort(404);
				break;
		}

		$this->save();

		return $this;
	}

	/**
	 * @param \Illuminate\Http\Request $request
	 */
	public function fillQuiz(Request $request)
	{
		$this->setMeta(
			$request->except(
				[
					'_token',
					'_step',
					'_method',
					'compliance_guideline',
					'logo',
					'article_images',
					'ready_content',
				]
			)
		);
		//$this->addFiles($request);
		$this->loadKeywords();
		$this->setState(\App\Models\Helpers\ProjectStates::KEYWORDS_FILLING);
	}

	/**
	 *
	 */
	private function loadKeywords()
	{
		$themes = collect(
			explode(',', $this->getMeta('themes'))
		);

		$api = new KeywordTool();

		$keywords = collect();

		$keywords = $themes->each(
			function ($theme, $key) use ($api) {
				if($key > 0){
					return false;
				}

				try {
					$result = collect();

					$response = $api->suggestions(trim($theme));
					$response = collect($response[$theme]);
					$result[$theme] = collect($response->pluck('string'));

				} catch (RequestException $e) {
					//todo handle KeywordTool error
				}
			}
		);

		dd($keywords);
	}

	/**
	 * @param string $state
	 * @return \App\Models\Project
	 * @throws \Exception
	 */
	public function setState($state)
	{
		throw_unless(
			$this->validateState($state),
			ImpossibleProjectState::class,
			__('Impossible state of project')
		);

		$this->state = $state;

		if ($this->isDirty()) {
			$this->save();
			$this->fireModelEvent('setState', false);
		}

		return $this;
	}

	/**
	 * @param $state
	 * @return bool
	 */
	public function validateState($state)
	{
		return in_array($state, ProjectStates::$states);
	}

	/**
	 * @param \Illuminate\Http\Request $request
	 */
	public function fillKeywords(Request $request)
	{
		dd($request->input('keywords'));
		$this->setMeta('keywords', $request->input('keywords'));
		$this->setState(\App\Models\Helpers\ProjectStates::MANAGER_REVIEW);
		$this->filled();
	}

	/**
	 * Fires model event "filled"
	 * Called after client fill all necessary data
	 * and project ready for manager review
	 */
	public function filled()
	{
		//TODO check project state if project filled, send events to workers
		$this->fireModelEvent('filled', false);
	}
}