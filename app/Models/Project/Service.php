<?php

namespace App\Models\Project;

use App\Models\Project;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Service
 *
 * @package App\Models\Project
 * @property int $id
 * @property int $project_id
 * @property string $name
 * @property string $display_name
 * @property int|mixed $default
 * @property int|mixed $custom
 * @property string $type
 * @property-read mixed $value
 * @property-read \App\Models\Project $project
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project\Service customized()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project\Service whereCustom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project\Service whereDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project\Service whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project\Service whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project\Service whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project\Service whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project\Service whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project\Service withType($type)
 * @mixin \Eloquent
 */
class Service extends Model
{
    /**
     * @const string
     */
    const TYPE_INTEGER = 'integer';
    /**
     * @const string
     */
    const TYPE_BOOLEAN = 'boolean';
    /**
     * @const string
     */
    const TYPE_RANGE = 'range';
    /**
     * @const string
     */
    const TYPE_STRING = 'string';

    /**
     * @var array
     */
    protected $fillable = [
        'project_id',
        'name',
        'display_name',
        'default',
        'custom',
        'type'
    ];

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * @param $query
     * @param $type
     * @return mixed
     */
    public function scopeWithType($query, $type)
    {
        return $query->where('type', '=', $type);
    }

    /**
     * Get casted value
     *
     * @param $value
     * @return int|mixed
     */
    public function getDefaultAttribute($value)
    {
        return $this->castFromType($value);
    }

    /**
     * Get casted value
     *
     * @param $value
     * @return int|mixed
     */
    public function getCustomAttribute($value)
    {
        return $this->castFromType($value);
    }

    /**
     * Get current value
     *
     * @return mixed
     */
    public function getValueAttribute()
    {
        return ($this->custom !== null)
            ? $this->custom
            : $this->default;
    }

    /**
     * Cast value depends on type
     *
     *
     * @param $value
     * @return int|mixed
     */
    private function castFromType($value)
    {
        switch ($this->type) {
            case self::TYPE_INTEGER :
                return intval($value);
            case self::TYPE_BOOLEAN :
                return filter_var($value, FILTER_VALIDATE_BOOLEAN);
            case self::TYPE_RANGE :
                return explode('-', $value);
        }
        return $value;
    }

    /**
     * @param $value
     */
    public function customize($value)
    {
        if ($this->type == self::TYPE_RANGE) {
            $value = implode('-', $value);
        }

        if ($this->type == self::TYPE_BOOLEAN) {
            $value = ($value) ? 'true' : 'false';
        }

        if ($this->type != self::TYPE_RANGE and is_array($value)) {
            throw new \Exception (sprintf('Value of the "%1$s" attribute should be "%2$s", but "%3$s" has beed passed', $this->display_name, $this->type, gettype($value)));
        }

        $this->custom = strval($value);

        if ($this->custom == $this->default) {
            $this->custom = null;
        }

        $this->save();
    }

    /**
     * Restore default value
     */
    public function restore()
    {
        $this->custom = null;
        $this->save();
    }

    /**
     * @param $query
     */
    public function scopeCustomized($query)
    {
        return $query->where('custom', '!=', null);
    }
}
