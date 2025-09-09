<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ComunidadePost;
use Illuminate\Support\Facades\Auth;

class ComunidadeController extends Controller
{
    // Exibir feed
    public function index()
    {
        $posts = ComunidadePost::with('user')
                    ->latest()
                    ->get();

        return view('Site.tipo.prof.comunidade.index', compact('posts'));
    }

    // Armazenar nova publicação
    public function store(Request $request)
    {
        $request->validate([
            'conteudo' => 'required|string|max:1000',
        ]);

        ComunidadePost::create([
            'user_id' => Auth::id(),
            'conteudo' => $request->conteudo,
        ]);

        return redirect()->back()->with('success', 'Publicação enviada com sucesso!');
    }
}
