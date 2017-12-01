<?php
/**
 * Created by PhpStorm.
 * User: imad
 * Date: 01/12/17
 * Time: 12:51
 */

namespace App\Models\Traits;

trait hasInvite
{
	public function getInvitableName() {
		return $this->name;
	}

	public function getInvitableId(){
		return $this->id;
	}
}