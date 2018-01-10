<?php

namespace App\Models;

use App\Jobs\MiniFyImage;
use App\Models\Interfaces\Invitable;
use App\Models\Traits\hasInvite;
use App\Models\Traits\Project\FormProjectAccessors;
use App\Models\Traits\Project\hasArticles;
use App\Models\Traits\Project\hasOutlines;
use App\Models\Traits\Project\hasPlan;
use App\Models\Traits\Project\hasStates;
use App\Models\Traits\Project\hasTeams;
use App\Models\Traits\Project\hasWorkers;
use App\Notifications\Project\Invite;
use App\User;
use BrianFaust\Commentable\Traits\HasComments;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Kodeine\Metable\Metable;
use Laravel\Cashier\Subscription;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMedia;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;
use Spatie\MediaLibrary\Media;
use Venturecraft\Revisionable\Revision;

/**
 * Class Project
 *
 * @package App\Models
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Article[] $articles
 * @property-read \App\User $client
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
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read mixed $plan
 * @property-read mixed $plan_metadata
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Project onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Project withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Project withoutTrashed()
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activity
 */
class Project extends Model implements HasMediaConversions, Invitable
{
    use hasStates;
    use hasWorkers;
    use hasTeams;
    use hasOutlines;
    use hasArticles;
    use Metable;
    use FormProjectAccessors;
    use HasMediaTrait;
    use hasInvite;
    use hasPlan;
    use SoftDeletes;
    use LogsActivity;

    /**
     *
     */
    const TAG_CATEGORY = 'service_type';

    /**
     * @var bool
     */
    protected static $logOnlyDirty = true;

    /**
     * @var array
     */
    protected static $logAttributes = ['name', 'text'];

    /**
     * Collections of project files
     * May contain results of quiz
     * and worker's metarials
     *
     * @var string[]
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
        'setState',
        'filled',
        'attachWorker',
        'attachWorkers',
        'detachWorker',
        'attachTeam',
        'attachArticle'
    ];

    /**
     * @var string[]
     */
    protected $dates = ['deleted_at'];

    /**
     * @var string
     */
    protected $metaTable = 'projects_meta';

    /**
     * @var array
     */
    protected $with = ['client', 'metas'];

    /**
     * Project's owner
     *
     *
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
     * Project's Stripe subscription
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    /**
     * Upload user's quiz files
     * May contain logo, ready content, images etc
     *
     *
     * @param \Illuminate\Http\Request $request
     * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileDoesNotExist
     * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileIsTooBig
     */
    public function addFiles(Request $request)
    {
        try {
            $files = collect();
            foreach (self::$media_collections as $file_input) {
                $media = $this->addFile($file_input, $request);
                if($media instanceof Media){
                    $files->push($media);
                }
            }
            return $files->filter();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @param Request $request
     * @return static
     * @throws \Exception
     */
    public function addMetaFiles(Request $request)
    {
        try {
            $files = collect();
            foreach ($request->file() as $file_name => $file) {
                $files->push($this->addFile($file_name, $request));
            }
            return $files->filter();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @param $file_input
     * @param Request $request
     * @return Media
     * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileDoesNotExist
     * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileIsTooBig
     */
    private function addFile($file_input, Request $request)
    {
        try {
            if ($request->hasFile($file_input)) {
                if (is_array($request->file($file_input))) {
                    foreach ($request->file($file_input) as $file) {
                        return $this->addMedia($file)->toMediaCollection($file_input);
                    }
                } else {
                    return $this->addMedia($request->file($file_input))->toMediaCollection($file_input);
                }
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Implementation of App\Models\Interfaces\Invitable interface
     * Used to show project's url in notification
     *
     * @return string
     */
    public function getInvitableUrl()
    {
        return url()->action('ProjectController@show', $this);
    }

    /**
     * Implementation of App\Models\Interfaces\Invitable interface
     * Used to invite someone to join this project
     *
     * @return string
     */
    public function getInvitableNotification()
    {
        return Invite::class;
    }

    /**
     * @return float|int
     */
    public function getProgress()
    {
        $key              = 'articles_count';
        $require_articles = ($this->isModified($key))
            ? $this->getModified($key)
            : $this->plan_metadata['articles_count'];

        $total_articles_accepted = $this->articles()->accepted()->count();

        return ($require_articles > 0)
            ? $total_articles_accepted / $require_articles * 100 : 0;
    }

    /**
     * @return string
     */
    public function export()
    {

        $ready_export = $this->getMeta('export');

        //return path to zip if exist
        if ($ready_export and file_exists($ready_export)) {
            return $ready_export;
        }

        $data = [];

        //collect main data
        $data['project']['name']    = $this->name;
        $data['project']['plan']    = $this->plan->name;
        $data['project']['require'] = [];
        $data['media']              = [];
        $data['client']['name']     = $this->client->name;
        $data['client']['email']    = $this->client->email;
        $data['client']['phone']    = $this->client->phone;

        //collect plan requirments
        foreach ($this->plan_metadata as $key => $value) {
            if ($this->isModified($key)) {
                $data['project']['require'][$key] = $this->getModified($key);
            } else {
                $data['project']['require'][$key] = $value;
            }
        }

        //collect media files
        foreach (self::$media_collections as $collection) {
            $collection_files = $this->getMedia($collection);
            if ($collection_files->isNotEmpty()) {
                $collection_files->each(function (Media $item) use (&$data, $collection) {
                    $data['media'][$collection][] = $item->getPath();
                    return;
                });
            }
        }

        $string = 'Project info:' . PHP_EOL;
        //build main string
        foreach ($data['project'] as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $sub_key => $sub_value) {
                    $string .= '   ' . $sub_key . ' : ' . $sub_value . PHP_EOL;
                }
            } else {
                $string .= $key . ' : ' . $value . PHP_EOL;
            }
        }

        $string .= PHP_EOL;

        $string .= 'Client info:' . PHP_EOL;

        //build client info string
        foreach ($data['client'] as $key => $value) {
            $string .= $key . ' : ' . $value . PHP_EOL;
        }


        $meta_string = 'Project quiz result:' . PHP_EOL;

        //build quiz result string
        foreach ($this->getMeta() as $meta_key => $meta_value) {
            if ($meta_value == '' or empty($meta_value) or is_object($meta_value)) {
                continue;
            }

            if (is_array($meta_value) and !empty($meta_value)) {
                $meta_string .= title_case(str_replace('_', ' ', $meta_key)) . PHP_EOL;
                foreach ($meta_value as $sub_key => $sub_value) {
                    if ($sub_value == '' or is_array($sub_value)) {
                        continue;
                    }
                    $meta_string .= '   ' . title_case(str_replace('_', ' ', $sub_key)) . ' : ' . $sub_value . PHP_EOL;
                }
            } else {
                if (trim($meta_value) == '') {
                    continue;
                }
                $meta_string .= title_case(str_replace('_', ' ', $meta_key)) . ' : ' . $meta_value . PHP_EOL;
            }
        }

        //zip everything
        $path = storage_path('app/exports/');

        $zipper = new \Chumper\Zipper\Zipper;

        $main_folder = 'project - ' . $this->name;

        $full_path = $path . $this->name . '.zip';

        $zipper->make($full_path)->folder($main_folder)->addString('main info', $string)
               ->addString('quiz result', $meta_string);

        //set media
        foreach ($data['media'] as $collection => $files) {
            $zipper->folder($main_folder . '/' . $collection)->add($files);
        }

        $zipper->close();

        //save path to zip to metadata
        $this->setMeta('export', $full_path);
        $this->save();

        return $full_path;

    }

    /**
     * @param $type
     * @return string
     */
    public function getTimelineIcon($type)
    {
        switch ($type) {
            case 'project_worker' :
                return 'fa-users';
                break;
            case 'project_progress' :
                return 'fa fa-line-chart';
                break;
            default:
                return 'fa-file-o';
                break;
        }
    }

    /**
     * @return mixed
     */
    public function metaToView()
    {
        $meta_to_cast = [
            'themes',
            'questions',
            'avoid_keywords',
            'article_images_links',
            'image_pages',
            'google_access',
        ];

        $meta_to_skip = [
            'themes_order',
            'keywords_meta',
            'keywords',
            'keywords_questions',
            'export',
            'conversation_id'
        ];

        $meta = $this->metas;

        $meta->transform(function ($item) use ($meta_to_cast, $meta_to_skip) {

            if (strpos($item->key, 'modificator_') !== false or in_array($item->key, $meta_to_skip)) {
                return null;
            }

            //is link
            $item->value = (filter_var($item->value, FILTER_VALIDATE_URL))
                ? '<a href="' . $item->value . '">' . $item->value . '</a>'
                : $item->value;

            if (in_array($item->key, $meta_to_cast)) {
                $item->value = explode(',', $item->value);
                //remove empty metas
                if (is_array($item->value) and empty($item->value)) {
                    return null;
                }
                //remove empty metas
                if (isset($item->value[0]) and empty($item->value[0])) {
                    return null;
                }
            }

            return $item;

        });

        return $meta->filter();
    }

    /**
     * @return static
     */
    public function getAvailableWorkers()
    {
        $users = User::without(['notifications', 'invites'])
                     ->whereNotIn('id', $this->workers->pluck('id')->toArray())
                     ->get(['id', 'first_name', 'last_name', 'email']);

        //prepare and filter users for the view

        $invitable_users = $users->keyBy('id')->transform(function (User $user) {
            if (in_array($user->role, ['admin', 'client'])) {
                return null;
            }

            $role = $user->roles()->first();

            $role_name = ($role) ? $role->display_name : '';

            return $user->name . " - {$role_name}";
        });

        return $invitable_users->filter();
    }

    /**
     * @param Media|null $media
     * @throws \Spatie\Image\Exceptions\InvalidManipulation
     */
    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('dropzone')
             ->crop('crop-center', 120, 120)->nonQueued();
    }

    /**
     * @param Media $media
     * @return string
     */
    public function prepareMediaConversion(Media $media)
    {
        try {
            return (File::exists($media->getPath('dropzone')))
                ? $media->getFullUrl('dropzone')
                : $media->getFullUrl();
        } catch (\Exception $e) {
            return $media->getFullUrl();
        }
    }
}
