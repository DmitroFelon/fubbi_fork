<?php

namespace App\Models\Users;

use App\Models\Role;
use App\Models\Traits\HasParentModel;
use App\User;
use Illuminate\Database\Eloquent\Builder;


class Admin extends User
{
    use HasParentModel;

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        //get only admins
        static::addGlobalScope('role', function (Builder $builder) {
            $builder->withRole(Role::ADMIN);
        });
    }
}
