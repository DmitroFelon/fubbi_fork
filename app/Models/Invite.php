<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Invite
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $project_id
 * @property int|null $team_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int $accepted
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invite whereAccepted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invite whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invite whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invite whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invite whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invite whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invite whereUserId($value)
 * @mixin \Eloquent
 */
class Invite extends Model
{
	/**
	 * @const string
	 */
	const PROJECT_INVITE_TYPE = 'project';

	/**
	 * @const string
	 */
	const TEAM_INVITE_TYPE = 'team';

	/**
	 * @var array
	 */
	protected $fillable = [
		'type',
		'user_id',
		'team_id',
		'project_id',
	];

	/**
	 * @var array
	 */
	protected $observables = [
		'accepted',
		'rejected'
	];

	/**
	 * @return array
	 */
	public function getAvailableInvites()
	{
		return [
			Project::class,
			Team::class
		];
	}

	/**
	 * @return array
	 */
	public static function getInviteRelations()
	{
		return [
			Project::class => self::PROJECT_INVITE_TYPE,
			Team::class    => self::TEAM_INVITE_TYPE,
		];
	}

	/**
	 * @return array
	 */
	public static function getInviteNotifications()
	{
		return [
			self::PROJECT_INVITE_TYPE => \App\Notifications\Project\Invite::class,
			self::TEAM_INVITE_TYPE    => \App\Notifications\Team\Invite::class,
		];
	}

	/**
	 * @param $query
	 * @return mixed
	 */
	public function scopeTeams($query)
	{
		return $query->where('type', '=', self::TEAM_INVITE_TYPE);
	}

	/**
	 * @param $query
	 * @return mixed
	 */
	public function scopeProjects($query)
	{
		return $query->where('type', '=', self::PROJECT_INVITE_TYPE);
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
		$this->fireModelEvent('accepted', false);
		return $this->save();
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

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function project()
	{
		return $this->belongsTo(Project::class);
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function team()
	{
		return $this->belongsTo(Team::class);
	}


}
