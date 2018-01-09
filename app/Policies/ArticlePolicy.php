<?php

namespace App\Policies;

use App\Models\Article;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticlePolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        return true;
    }

    public function show(User $user, Article $article)
    {
        return true;
    }

    public function update(User $user, Article $article)
    {
        return true;
    }
}
