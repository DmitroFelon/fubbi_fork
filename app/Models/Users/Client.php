<?php

namespace App\Models\Users;

use App\Models\Role;
use App\User;
use Illuminate\Database\Eloquent\Builder;


class Client extends User
{
    protected $table = 'users';

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::addGlobalScope('age', function (Builder $builder) {
            $builder->withRole(Role::ADMIN);
        });
    }
}
