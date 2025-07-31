<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PostComment;
use Illuminate\Support\Facades\Auth;

class PostCommentController extends Controller
{
    public function comentar(Request $request, $id)
    {
        $request->validate([
            'conteudo' => 'required|string|max:1000',
        ]);

        PostComment::create([
            'user_id' => Auth::id(),
            'comunidade_post_id' => $id,
            'conteudo' => $request->conteudo,
        ]);

        return back();
    }
}
