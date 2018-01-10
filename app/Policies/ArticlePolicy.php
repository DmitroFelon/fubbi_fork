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
     * @param Project $project
     * @return bool
     */
    public function index(User $user, Project $project)
    {
        return $user->projects()->find($project->id)->exists();
    }

    /**
     * @param User $user
     * @param Project $project
     * @param Article $article
     * @return bool
     */
    public function update(User $user, Project $project, Article $article)
    {

        return $user->projects()->find($project->id)->exists();
    }

    /**
     * @param User $user
     * @param Project $project
     * @return bool
     */
    public function create(User $user, Project $project)
    {
        return $user->projects()->find($project->id)->exists();
    }

    /**
     * @param User $user
     * @param Project $project
     * @param Article $article
     * @return bool
     */
    public function delete(User $user, Project $project, Article $article)
    {
        return $user->projects()->find($project->id)->exists();
    }

    /**
     * @param User $user
     * @param Project $project
     * @param Article $article
     * @return bool
     */
    public function accept(User $user, Project $project, Article $article)
    {
        return ($project->client_id == $user->id);
    }
}
