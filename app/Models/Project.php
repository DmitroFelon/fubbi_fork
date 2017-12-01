<?php

namespace App\Models;

use App\Models\Interfaces\Invitable;
use App\Models\Traits\hasInvite;
use App\Models\Traits\Project\hasArticles;
use App\Models\Traits\Project\FormProjectAccessors;
use App\Models\Traits\Project\hasKeywords;
use App\Models\Traits\Project\hasOutlines;
use App\Models\Traits\Project\hasStates;
use App\Models\Traits\Project\hasTeams;
use App\Models\Traits\Project\hasWorkers;
use App\Notifications\Project\Invite;
use App\User;
use BrianFaust\Commentable\Traits\HasComments;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Kodeine\Metable\Metable;
use Laravel\Cashier\Subscription;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMedia;
use Venturecraft\Revisionable\Revision;

/**
 * Class Project
 *
 * @package App\Models
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Article[] $articles
 * @property-read \App\User $client
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Keyword[] $keywords
 * @property-read \Illuminate\Database\Eloquent\Collection|Revision[] $revisionHistory
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Team[] $teams
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Topic[] $topics
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $workers
 * @method static Builder|\App\Models\Project meta()
 * @mixin \Eloquent
 * @property int $id
 * @property int $client_id
 * @property string $name
 * @property string $description
 * @property string $state
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static Builder|\App\Models\Project whereClientId($value)
 * @method static Builder|\App\Models\Project whereCreatedAt($value)
 * @method static Builder|\App\Models\Project whereId($value)
 * @method static Builder|\App\Models\Project whereName($value)
 * @method static Builder|\App\Models\Project whereState($value)
 * @method static Builder|\App\Models\Project whereUpdatedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\MediaLibrary\Media[] $media
 * @property int $subscription_id
 * @property-read \Kalnoy\Nestedset\Collection|\BrianFaust\Commentable\Models\Comment[] $comments
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Outline[] $outlines
 * @property-read \Laravel\Cashier\Subscription $subscription
 * @property-read \App\Models\Task $task
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project whereSubscriptionId($value)
 */
class Project extends Model implements HasMedia, Invitable
{
	use hasKeywords;
	use hasStates;
	use hasWorkers;
	use hasTeams;
	use hasOutlines;
	use hasArticles;
	use Metable;
	use FormProjectAccessors;
	use HasMediaTrait;
	use HasComments;
	use hasInvite;

	/**
	 * @const string
	 */
	const CREATED = 'created';

	/**
	 * @const string
	 */
	const PLAN_SELECTION = 'plan';

	/**
	 * @const string
	 */
	const QUIZ_FILLING = 'quiz';

	/**
	 * @const string
	 */
	const KEYWORDS_FILLING = 'keywords';

	/**
	 * @const string
	 */
	const MANAGER_REVIEW = 'on_manager_review';

	/**
	 * @const string
	 */
	const PROCESSING = 'processing';

	/**
	 * @const string
	 */
	const CLIENT_REVIEW = 'on_client_review';

	/**
	 * @const string
	 */
	const ACCEPTED_BY_CLIENT = 'accepted_by_client';

	/**
	 * @const string
	 */
	const REJECTED_BY_CLIENT = 'rejected_by_client';

	/**
	 * @const string
	 */
	const COMPLETED = 'completed';

	/**
	 * @var array
	 */
	public static $media_collections = [
		'article_images',
		'compliance_guideline',
		'logo',
		'ready_content',
	];

	/**
	 * Additional observable events.
	 */
	protected $observables = [
		'attachKeywords',
		'detachKeywords',
		'syncKeywords',
		'attachWorkers',
		'detachWorkers',
		'syncWorkers',
		'setState',
		'filled'
	];

	/**
	 * Project constructor.
	 *
	 * @param array $attributes
	 */
	public function __construct(array $attributes = [])
	{
		parent::__construct($attributes);
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function client()
	{
		return $this->belongsTo(User::class, 'client_id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function task()
	{
		return $this->hasOne(Task::class);
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function subscription()
	{
		return $this->belongsTo(Subscription::class);
	}

	/**
	 * @param \Illuminate\Http\Request $request
	 * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileDoesNotExist
	 * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileIsTooBig
	 */
	public function addFiles(Request $request)
	{
		foreach (self::$media_collections as $file_input) {
			if ($request->hasFile($file_input)) {
				if(is_array($request->file($file_input))){
					foreach ($request->file($file_input) as $file) {
						$this->addMedia($file)->toMediaCollection($file_input);
					}
				}else{
					$this->addMedia($request->file($file_input))->toMediaCollection($file_input);
				}
			}
		}
	}

	/**
	 * Fires model event "filled"
	 */
	public function filled(){

		//TODO check project state if project filled, send events to workers
		$this->fireModelEvent('filled', false);
	}

	/**
	 * @return string
	 */
	public function getInvitableUrl()
	{
		return url()->action('ProjectController@show', $this);
	}

	public function getInvitableNotification()
	{
		return Invite::class;
	}
}
