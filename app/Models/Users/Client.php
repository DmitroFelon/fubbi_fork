<?php
/**
 * Created by PhpStorm.
 * User: imad
 * Date: 06/11/17
 * Time: 11:53
 */

namespace App\Models\Users;

use App\Models\Project;
use App\User;

class Client extends User
{
    public static function all($columns = ['*'])
    {
        return \App\Models\Role::where('name', 'client')
            ->first()
            ->users()
            ->distinct()
            ->get($columns);
    }

    public function projects()
    {
        return $this->hasMany(Project::class, 'client_id');
    }
}