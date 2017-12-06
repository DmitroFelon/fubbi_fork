<?php
/**
 * Created by PhpStorm.
 * User: imad
 * Date: 08/11/17
 * Time: 11:13
 */

namespace App\Models\Traits\Project;

use App\Models\Keyword;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Class hasKeywords
 * 
 * attach App\Models\Keyword to App\Models\Project
 *
 * @package App\Models\Traits\Project
 */
trait hasKeywords
{
	/**
     * @param $args
     */
    public function attachKeywords($args)
    {
        $this->keywords()->attach($args);
        $this->fireModelEvent('attachKeywords', false);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function keywords()
    {
        return $this->belongsToMany(Keyword::class);
    }

	/**
     * @param $args
     */
    public function detachKeywords($args)
    {
        $this->keywords()->detach($args);
        $this->fireModelEvent('detachKeywords', false);
    }

	/**
     * @param $args
     */
    public function syncKeywords($args)
    {

        $this->createRevisionRecord($this, 'keywords', array_values($this->keywords()->pluck('keyword_id')->toArray()), $args);

        $this->keywords()->sync($args);

        $this->fireModelEvent('syncKeywords', false);
    }

	/**
     * @param $obj
     * @param $key
     * @param null $old
     * @param null $new
     * @return bool|null
     */
    public static function createRevisionRecord($obj, $key, $old = null, $new = null)
    {

        if (empty(array_diff($old, $new))) {
            return null;
        }

        $revisions = [
            [
                'revisionable_type' => get_class($obj),
                'revisionable_id' => $obj->getKey(),
                'key' => $key,
                'old_value' => json_encode($old),
                'new_value' => json_encode($new),
                'user_id' => (Auth::check()) ? Auth::user()->id : null,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime(),
            ],
        ];

        $revision = new \Venturecraft\Revisionable\Revision;
        DB::table($revision->getTable())->insert($revisions);

        return true;
    }
}