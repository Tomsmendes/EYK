<?php
namespace App\Policies;

use App\Models\ComunidadePost;
use App\Models\User;

class PostPolicy
{
    /**
     * Só o dono pode apagar.
     */
    public function delete(User $user, ComunidadePost $post)
    {
        return $user->id === $post->user_id;
    }
}

