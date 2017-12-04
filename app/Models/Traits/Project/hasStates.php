<?php
/**
 * Created by PhpStorm.
 * User: imad
 * Date: 09/11/17
 * Time: 12:33
 */

namespace App\Models\Traits\Project;

use App\Exceptions\Project\ImpossibleProjectState;
use App\Models\Project;

/**
 * Class hasStates
 *
 * @package App\Models\Traits\Project
 */
trait hasStates
{
	/**
	 * @var array
	 */
	protected $states = [
		Project::CREATED,
		Project::PLAN_SELECTION,
		Project::QUIZ_FILLING,
		Project::KEYWORDS_FILLING,
		Project::MANAGER_REVIEW,
		Project::PROCESSING,
		Project::CLIENT_REVIEW,
		Project::ACCEPTED_BY_CLIENT,
		Project::REJECTED_BY_CLIENT,
		Project::COMPLETED,
	];

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
	 * @throws \Throwable
	 * @throws string
	 */
	public function validateState($state)
	{
		return in_array($state, $this->states);
	}
}