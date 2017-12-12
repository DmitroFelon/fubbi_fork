<?php

namespace App;

use App\Models\Annotation;
use App\Models\Article;
use App\Models\Interfaces\Invitable;
use App\Models\Invite;
use App\Models\Outline;
use App\Models\Project;
use App\Models\Role;
use App\Models\Team;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Laravel\Scout\Searchable;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMedia;
use Zizaco\Entrust\Traits\EntrustUserTrait;

/**
 * App\User
 *
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Project[] $projects
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Role[] $roles
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Cashier\Subscription[] $subscriptions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Team[] $teams
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string|null $stripe_id
 * @property string|null $card_brand
 * @property string|null $card_last_four
 * @property string|null $trial_ends_at
 * @property string|null $remember_token
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCardBrand($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCardLastFour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereStripeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereTrialEndsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Annotation[] $annotations
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User withRole($role)
 * @property string $first_name
 * @property string $last_name
 * @property string $phone
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Article[] $articles
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\MediaLibrary\Media[] $media
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Outline[] $outlines
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePhone($value)
 * @property string|null $deleted_at
 * @property-read null $role
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Invite[] $invites
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereDeletedAt($value)
 */
class User extends Authenticatable implements HasMedia
{
	use Notifiable;
	use Billable;
	use EntrustUserTrait;
	use HasMediaTrait;
	use Searchable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'first_name',
		'last_name',
		'phone',
		'email',
		'password',
	];
	
	protected $searchble = [];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password',
		'remember_token',
		'stripe_id',
		'card_brand',
		'card_last_four',
		'trial_ends_at',
	];

	/**
	 * @var array
	 */
	protected $with = [
		'roles',
		'projects',
		'invites',
		'notifications'
	];

	/**
	 * @var array
	 */
	protected $appends = ['role'];

	public function toSearchableArray()
	{

		return [
			'first_name' => $this->first_name,
			'last_name' => $this->last_name,
			'email' => $this->email,
		];
	}

	/**
	 * @return null
	 */
	public function getRoleAttribute()
	{
		return $this->getRole();
	}

	/**
	 * @return null
	 */
	public function getRole()
	{
		foreach (Role::$roles as $r) {
			if ($this->hasRole($r)) {
				return $r;
			}
		}

		return null;
	}

	/**
	 * @return string
	 */
	public function routeNotificationForMail()
	{
		return $this->email;
	}

	/**
	 * @return string
	 */
	public function routeNotificationForPhone()
	{
		return $this->phone;
	}

	/**
	 * @return string
	 */
	public function getNameAttribute()
	{
		return $this->first_name.' '.$this->last_name;
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function projects()
	{
		if ($this->getRole() == 'client') {
			return $this->hasMany(Project::class, 'client_id');
		}

		return $this->belongsToMany(Project::class, 'project_worker', 'user_id', 'project_id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function teams()
	{
		return $this->belongsToMany(Team::class, 'team_user', 'user_id', 'team_id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function annotations()
	{
		return $this->hasMany(Annotation::class);
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function articles()
	{
		return $this->hasMany(Article::class);
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function outlines()
	{
		return $this->hasMany(Outline::class);
	}

	/**
	 * @param \App\Models\Interfaces\Invitable $whereInvite
	 */
	public function inviteTo(Invitable $whereInvite)
	{
		$invite = new Invite(
			[
				'invitable_type' => get_class($whereInvite),
				'invitable_id'   => $whereInvite->getInvitableId(),
				'user_id'        => $this->id,
			]
		);

		$invite->save();
	}

	public function hasInvitetoProject($project_id)
	{
		return $this->invites()->where('invitable_id', $project_id)->projects()->new()->get()->isNotEmpty();
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function invites()
	{
		return $this->hasMany(Invite::class);
	}

	public function getInviteToProject($project_id)
	{
		return $this->invites()->projects()->where('invitable_id', $project_id)->new()->get()->first();
	}

}
