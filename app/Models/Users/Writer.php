<?php
/**
 * Created by PhpStorm.
 * User: imad
 * Date: 06/11/17
 * Time: 11:53
 */

namespace App\Models\Users;

use App\User;
use Ghanem\Rating\Traits\Ratingable;

class Writer extends User
{
    use Ratingable;
}