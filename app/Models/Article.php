<?php

namespace App\Models;

use App\Services\Google\Drive;
use App\User;
use BrianFaust\Commentable\Traits\HasComments;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Kodeine\Metable\Metable;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMedia;
use Spatie\Tags\HasTags;
use Spatie\Tags\Tag;

/**
 * App\Models\Article
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Project[] $projects
 * @mixin \Eloquent
 * @property int $id
 * @property string $text
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereText($value)
 * @property int $user_id
 * @property int $project_id
 * @property int $accepted
 * @property int $attempts
 * @property string $title
 * @property string $body
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\User $author
 * @property-read \Kalnoy\Nestedset\Collection|\BrianFaust\Commentable\Models\Comment[] $comments
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\MediaLibrary\Media[] $media
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereAccepted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereAttempts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereUserId($value)
 * @property \Carbon\Carbon|null $deleted_at
 * @property \Illuminate\Database\Eloquent\Collection|\Spatie\Tags\Tag[] $tags
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Article onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article withAllTags($tags, $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article withAnyTags($tags, $type = null)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Article withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Article withoutTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article accepted()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article declined()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article new()
 * @property string|null $google_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article meta()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereGoogleId($value)
 */
class Article extends Model implements HasMedia
{
    use HasMediaTrait;
    use HasComments;
    use SoftDeletes;
    use Metable;
    use HasTags;

    /**
     * @var array
     */
    protected $fillable = [
        'title',
        'body',
        'type',
        'user_id'
    ];

    /**
     * @var string
     */
    protected $metaTable = 'article_meta';

    /**
     * @var array
     */
    protected $with = ['projects', 'metas'];

    /**
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * One article may belong to many projects
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function projects()
    {
        return $this->belongsToMany(Project::class)->withPivot('accepted', 'attempts')->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
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
    public function scopeDeclined($query)
    {
        return $query->where('accepted', '=', false);
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
     * Attach specific service tag to article
     *
     * @param string $tag
     */
    public function attachTagsHelper($tag)
    {
        $this->attachTag(Tag::findOrCreate($tag, Project::TAG_CATEGORY));
    }

    /**
     * @return mixed
     */
    public function getGooglePath()
    {
        return $this->getMeta('google_path');
    }

    /**
     * @param array $google_path
     */
    public function setGooglePath(array $google_path)
    {
        $this->setMeta('google_path', $google_path);
        $this->save();

    }

    /**
     * @param string $as
     * @return \Spatie\MediaLibrary\Media
     * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileDoesNotExist
     * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileIsTooBig
     */
    public function export($as = Drive::MS_WORD)
    {
        $api = new Drive();

        $file = $api->exportFile($this->google_id, $as);

        $file_name = $this->google_id . '.' . Drive::getExtension($as);

        file_put_contents(storage_path('app/temp/' . $file_name), $file);

        $media = $this->addMedia(storage_path('app/temp/' . $file_name))->toMediaCollection('google_export');

        return $media;
    }

    public function getTypes(Project $project)
    {
        $types = collect(
            [
                ''                   => _i('Select Type'),
                'Article Outline'    => _i('Article Outline'),
                'Article Topic'      => _i('Article Topic'),
                'Article'            => _i('Article'),
                'Social Posts Texts' => _i('Social Posts Texts'),
            ]
        );

        collect($project->getVariableServices())->each(function ($item) use ($types, $project) {
            if ($project->isRequireService($item)) {
                $types->put($item, $project->getServiceName($item));
            }
        });

        return $types;
    }


    public static function getAllTypes()
    {

        $project = new Project();

        $types = collect(
            [
                ''                   => _i('Select Type'),
                'Article Outline'    => _i('Article Outline'),
                'Article Topic'      => _i('Article Topic'),
                'Article'            => _i('Article'),
                'Social Posts Texts' => _i('Social Posts Texts'),
            ]
        );

        collect($project->getVariableServices())->each(function ($item) use ($types, $project) {
            $types->put($item, $project->getServiceName($item));
        });

        return $types;
    }
}
