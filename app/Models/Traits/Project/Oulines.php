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
 * @package App\Models\Traits\Project
 */
trait Oulines
{
	/**
	 * @return mixed
	 */
	public function oulines()
	{
		return $this->belongsToMany(Outline::class);
	}
}