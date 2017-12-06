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
	 * @var string[]
	 */
	protected $states = [
		Project::CREATED,
		Project::PLAN_SELECTION,
		Project::QUIZ_FILLING,
		Project::KEYWORDS_FILLING,
		Project::MANAGER_REVIEW,
		Project::ACCEPTED_BY_MANAGER,
		Project::REJECTED_BY_MANAGER,
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
	 * @return bool
	 */
	public function validateState($state)
	{
		return in_array($state, $this->states);
	}

	/**
	 * Fires model event "filled" 
	 * Called after client fill all necessary data
	 * and project ready for manager review
	 */
	public function filled(){
		//TODO check project state if project filled, send events to workers
		$this->fireModelEvent('filled', false);
	}
}