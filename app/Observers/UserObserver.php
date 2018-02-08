<?php
/**
 * Created by PhpStorm.
 * User: imad
 * Date: 20/11/17
 * Time: 12:45
 */

namespace App\Observers;

use App\Models\Role;
use App\Notifications\Client\Registered;
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

            $admins = User::withRole(Role::ADMIN)->get();

            $admins->each(function (User $admin) use ($user) {
                //check is this notification not disabled
                if ($admin->isNotificationEnabled(\App\Notifications\Client\Registered::class)) {
                    $admin->notify(new Registered($user));
                }
            });
        }
    }

}