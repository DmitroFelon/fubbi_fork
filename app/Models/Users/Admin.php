<?php
/**
 * Created by PhpStorm.
 * User: imad
 * Date: 06/11/17
 * Time: 11:52
 */

namespace App\Models\Users;

use App\User;

class Admin extends User
{
    public static function all($columns = ['*'])
    {
        return \App\Models\Role::where('name', 'admin')
            ->first()
            ->users()
            ->distinct()
            ->get($columns);
    }
}