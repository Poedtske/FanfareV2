<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{

    public function promote(User $user)
    {
        // return $user->id === $post->user_id;
        return $user->role=='admin';
    }

    public function demote(User $user)
    {
        // return $user->id === $post->user_id;
        return $user->role=='admin';
    }

    public function update(User $user)
    {
        // return $user->id === $post->user_id;
        return $user->role=='admin';
    }

    public function delete(User $user)
    {
        // return $user->id === $post->user_id;
        return $user->role=='admin';
    }
}
