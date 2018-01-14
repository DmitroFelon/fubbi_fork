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
        return $this->hasMany(Article::class);
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
        $article           = $this->articles()->find($article_id);
        $article->accepted = true;
        $article->save();
        $this->eventData['acceptArticle'] = $article_id;
        $this->fireModelEvent('acceptArticle', false);
    }

    /**
     * @param $article_id
     */
    public function declineArticle($article_id)
    {
        $article  = $this->articles()->find($article_id);
        $attempts = $article->attempts;

        $article->accepted = false;
        $article->attempts = $attempts + 1;

        $article->save();

        if ($attempts > 3) {
            $this->eventData['lastDeclineArticle'] = $article_id;
            $this->fireModelEvent('lastDeclineArticle', false);
            //todo notify about limit of attempts 
            //todo move 3 to settings 
        } else {
            $this->eventData['declineArticle'] = $article_id;
            $this->fireModelEvent('declineArticle', false);
        }
    }

    public function getArticleByType(string $type)
    {
        return $this->articles()->where('type', $type);
    }
}