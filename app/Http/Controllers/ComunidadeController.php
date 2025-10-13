<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ComunidadePost;   // ✅ Importa o model correto
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class ComunidadeController extends Controller
{
    use AuthorizesRequests;
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

    // Apagar publicação
    public function destroy($id)
{
    $post = ComunidadePost::findOrFail($id);

    if ($post->user_id !== auth()->id()) {
        abort(403, 'Ação não autorizada.');
    }

    $post->delete();

    return back()->with('success', 'Post apagado com sucesso!');
}




}
