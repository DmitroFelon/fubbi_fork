<?php
/**
 * Created by PhpStorm.
 * User: imad
 * Date: 29/11/17
 * Time: 12:53
 */

namespace App\Models\Traits\Project;

use App\Models\Outline;

/**
 * Class Oulines
 *
 * attach App\Models\Outline to App\Models\Project
 *
 * @package App\Models\Traits\Project
 */
trait hasOutlines
{

	/**
	 * @return mixed
	 */
	public function outlines()
	{
		return $this->belongsToMany(Outline::class)->withPivot('accepted', 'attempts')->withTimestamps();
	}

	public function attachOutline($outline_id)
	{
		$this->outlines()->attach($outline_id, ['attempts' => 1]);
	}

	public function detachOutline($outline_id)
	{
		$this->outlines()->detach($outline_id);
	}

	/**
	 * @param $args
	 */
	public function syncOulines($args)
	{
		$this->outlines()->sync($args);
	}

	public function acceptOutline($outline_id)
	{
		$this->outlines()->updateExistingPivot($outline_id, ['accepted' => true], true);
	}

	public function declineOutline($outline_id)
	{
		
		$attempts = $this->outlines()->find($outline_id)->pivot->attempts + 1;
		
		$data = [
			'accepted' => false,
			'attempts' => $this->outlines()->find($outline_id)->pivot->attempts + 1
		];

		$this->outlines()->updateExistingPivot($outline_id, $data, true);
		
		if($attempts > 3){
			//todo notify about limit of attempts 
			//todo move 3 to settings 
		}
	}
}