<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\Project;
use App\Models\Role;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class ArticlePolicy
 * @package App\Policies
 */
class ArticlePolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @param $ability
     * @return bool
     */
    public function before(User $user, $ability)
    {
        $skip = [
            Role::ADMIN,
        ];

        if (in_array($user->role, $skip)) {
            return true;
        }
    }

    /**
     * @param User $user
     * @param Project $model
     * @return bool
     */
    public function index(User $user, Project $model)
    {
        return $user->projects()->find($model->id)->exists();
    }

    /**
     * @param User $user
     * @param Project $model
     * @param Article $article
     * @return bool
     */
    public function update(User $user, Project $model, Article $article)
    {

        return $user->projects()->find($model->id)->exists();
    }

    /**
     * @param User $user
     * @param Project $model
     * @return bool
     */
    public function create(User $user, Project $model)
    {
        return $user->projects()->find($model->id)->exists();
    }

    /**
     * @param User $user
     * @param Project $model
     * @param Article $article
     * @return bool
     */
    public function delete(User $user, Project $model, Article $article)
    {
        return $user->projects()->find($model->id)->exists();
    }

    /**
     * @param User $user
     * @param Project $model
     * @param Article $article
     * @return bool
     */
    public function accept(User $user, Project $model, Article $article)
    {
        return ($model->client_id == $user->id);
    }
}
