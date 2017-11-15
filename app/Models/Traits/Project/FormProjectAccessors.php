<?php
/**
 * Created by PhpStorm.
 * User: imad
 * Date: 15/11/17
 * Time: 15:44
 */

namespace App\Models\Traits\Project;

trait FormProjectAccessors
{

	public function formClientIdAttribute($value)
	{
		return \GuzzleHttp\json_decode($value);
	}


}