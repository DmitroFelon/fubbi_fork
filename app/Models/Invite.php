<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Invite extends Model
{
	/**
	 * @var array
	 */
	protected $fillable = [
		'invitable_type',
		'invitable_id',
		'user_id',
	];

	/**
	 * @var array
	 */
	protected $observables = [
		'accepted',
		'rejected'
	];

	/**
	 * @param $query
	 * @return mixed
	 */
	public function scopeTeams($query)
	{
		return $query->where('type', '=', Team::class);
	}

	/**
	 * @param $query
	 * @return mixed
	 */
	public function scopeProjects($query)
	{
		return $query->where('type', '=', Project::class);
	}

	/**
	 * @param $query
	 * @return mixed
	 */
	public function scopeNew($query)
	{
		return $query->where('accepted', '=', null);
	}

	/**
	 * @param $query
	 * @return mixed
	 */
	public function scopeAccepted($query)
	{
		return $query->where('accepted', '=', true);
	}

	/**
	 * @param $query
	 * @return mixed
	 */
	public function scopeRejected($query)
	{
		return $query->where('accepted', '=', false);
	}

	/**
	 * @return bool
	 */
	public function accept()
	{
		$this->accepted = true;
		$this->save();
		$this->fireModelEvent('accepted', false);
	}

	/**
	 * @return bool
	 */
	public function reject()
	{
		$this->accepted = false;
		$this->fireModelEvent('rejected', false);
		return $this->save();
	}

	public function invitable()
	{
		return $this->belongsTo(
			$this->invitable_type,
			'invitable_id'
		);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

}
