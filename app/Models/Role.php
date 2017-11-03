<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public static $roles = [
        'admin',
        'client',
        'account_manager',
        'writer',
        'editor',
        'designer'
    ];

    const ADMIN = 'admin';
    const CLIENT = 'client';
    const ACCOUNT_MANAGER = 'account_manager';
    const WRITER = 'writer';
    const EDITOR = 'editor';
    const DESIGNER = 'designer';

}
