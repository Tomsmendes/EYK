<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PostLike;
use App\Models\ComunidadePost;
use Illuminate\Support\Facades\Auth;

class PostLikeController extends Controller
{
    public function curtir($id)
    {
        $user = Auth::user();

        // Verifica se o usuário já curtiu
        $existe = PostLike::where('user_id', $user->id)
                          ->where('comunidade_post_id', $id)
                          ->first();

        if (!$existe) {
            PostLike::create([
                'user_id' => $user->id,
                'comunidade_post_id' => $id,
            ]);
        }

        return back();
    }
}
