<?php

namespace App\Policies;

use App\Models\User;

class SponsorPolicy
{
    public function create(User $user)
    {
        // return $user->id === $post->user_id;
        return $user->role=='admin';
    }

    public function changeState(User $user)
    {
        // return $user->id === $post->user_id;
        return $user->role=='admin';
    }

    public function store(User $user)
    {
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
