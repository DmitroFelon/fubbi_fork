<?php
/**
 * Created by PhpStorm.
 * User: imad
 * Date: 20/11/17
 * Time: 12:45
 */

namespace App\Observers;

use App\Models\Role;
use App\Notifications\RegistrationConfirmation;
use App\User;
use Illuminate\Support\Facades\Request;


class UserObserver
{
    public function created(User $user)
    {
        if (Request::input('role')) {
            $user->notify(new RegistrationConfirmation($user));
        } else {
            $admins = User::withRole('admin')->get();
            $admins->each(function (User $item, $key) use ($user) {
                $item->notify(new \App\Notifications\Client\Registered($user));
            });
        }
    }

}