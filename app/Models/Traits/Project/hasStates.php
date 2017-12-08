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
use App\Models\Project;

/**
 * Class hasStates
 *
 * @package App\Models\Traits\Project
 */
trait hasStates
{

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
	 * Fires model event "filled" 
	 * Called after client fill all necessary data
	 * and project ready for manager review
	 */
	public function filled(){
		//TODO check project state if project filled, send events to workers
		$this->fireModelEvent('filled', false);
	}

	public function isOnReview()
	{
		$reviewable_states = [
			ProjectStates::MANAGER_REVIEW,
		];

		return in_array($this->state, $reviewable_states);
	}
}