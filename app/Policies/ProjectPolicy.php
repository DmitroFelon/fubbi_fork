<?php

namespace App\Policies;

use App\Models\Role;
use App\User;
use App\Models\Project;
use Illuminate\Auth\Access\HandlesAuthorization;

//TODO implement actions authorisation
class ProjectPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the project.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function index(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can create projects.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function create(User $user)
    {

        $allow = [
            Role::ADMIN,
            Role::CLIENT,
        ];

        return (in_array($user->role, $allow));
    }

    /**
     * Determine whether the user can update the project.
     *
     * @param  \App\User $user
     * @param  \App\Models\Project $model
     * @return mixed
     */
    public function update(User $user, Project $model)
    {
        $skip = [
            Role::ADMIN,
            Role::ACCOUNT_MANAGER,
        ];

        if (in_array($user->role, $skip)) {
            return true;
        }

        if ($model->client_id == $user->id) {
            return true;
        }

        return ($user->projects()->find($model->id)->exists());
    }

    /**
     * Determine whether the user can delete the project.
     *
     * @param  \App\User $user
     * @param  \App\Models\Project $model
     * @return mixed
     */
    public function delete(User $user, Project $model)
    {
        $skip = [

        ];

        if (in_array($user->role, $skip)) {
            return true;
        }

        return ($model->client_id == $user->id);
    }
}
