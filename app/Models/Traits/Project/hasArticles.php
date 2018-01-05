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
 * attach App\Models\Article to App\Models\Project
 *
 * @package App\Models\Traits\Project
 */
trait hasArticles
{
    /**
     * @return mixed
     */
    public function articles()
    {
        return $this->belongsToMany(Article::class)->withPivot('accepted', 'attempts')->withTimestamps();
    }

    /**
     * @param $article_id
     * @return mixed
     */
    public function attachArticle($article_id)
    {
        return $this->articles()->attach($article_id, ['attempts' => 1]);

        $this->eventData['attachArticle'] = $article_id;

        $this->fireModelEvent('attachArticle', false);
    }

    /**
     * @param $article_id
     * @return mixed
     */
    public function detachArticle($article_id)
    {
        return $query = $this->articles()->detach($article_id);
    }

    /**
     * @param $args
     */
    public function syncArticle($args)
    {
        return $this->articles()->sync($args);
    }

    /**
     * @param $article_id
     */
    public function acceptArticle($article_id)
    {
        $this->articles()->updateExistingPivot($article_id, ['accepted' => true], true);
    }

    /**
     * @param $article_id
     */
    public function declineArticle($article_id)
    {

        $attempts = $this->articles()->find($article_id)->pivot->attempts + 1;

        $data = [
            'accepted' => false,
            'attempts' => $this->articles()->find($article_id)->pivot->attempts + 1
        ];

        $this->articles()->updateExistingPivot($article_id, $data, true);

        if ($attempts > 3) {
            //todo notify about limit of attempts 
            //todo move 3 to settings 
        }
    }

    public function getArticleByType(string $type)
    {
        return $this->articles()->where('type', $type);
    }
}