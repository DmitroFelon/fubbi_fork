<?php
/**
 * Created by PhpStorm.
 * User: imad
 * Date: 08/11/17
 * Time: 11:39
 */

namespace App\Models\Traits\Project;

use App\Models\Article;

/**
 * Class Articles
 *
 * @package App\Models\Traits\Project
 */
trait Articles
{
	/**
     * @return mixed
     */
    public function articles()
    {
        return $this->belongsToMany(Article::class);
    }

}