<?php
/**
 * Created by PhpStorm.
 * User: imad
 * Date: 06/11/17
 * Time: 11:53
 */

namespace App\Models\Users;

use App\Models\Team;
use App\User;
use Ghanem\Rating\Traits\Ratingable;

class Designer extends User
{
    use Ratingable;

    public static function all($columns = ['*'])
    {
        return \App\Models\Role::where('name', 'designer')
            ->first()
            ->users()
            ->distinct()
            ->get($columns);
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class, 'team_user', 'user_id', 'team_id');
    }
}