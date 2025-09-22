<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;
use Illuminate\Support\Facades\Auth;
use App\Models\Aula;

class VideoController extends Controller
{

    public function create()
    {
        $aulas = Aula::all();
        return view('Site.Pages.videos.create', compact('aulas'));
    }


    public function store(Request $request)
    {
    $request->validate([
        'titulo' => 'required|string|max:255',
        'video' => 'required|mimes:mp4,webm|max:51200', // 50MB
        'thumbnail' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        'aula_id' => 'nullable|exists:aulas,id', // valida que pode ser null ou id válido
    ]);

    $videoPath = $request->file('video')->store('videos', 'public');
    $thumbPath = $request->hasFile('thumbnail')
        ? $request->file('thumbnail')->store('thumbnails', 'public')
        : null;

    Video::create([
        'titulo' => $request->titulo,
        'descricao' => $request->descricao,
        'caminho_video' => $videoPath,
        'caminho_thumbnail' => $thumbPath,
        'user_id' => Auth::id(),
        'aula_id' => $request->filled('aula_id') ? $request->aula_id : null, // 👈 aqui
    ]);

    return redirect()->route('videos.index')->with('success', 'Vídeo enviado com sucesso!');
}


    public function index()
    {
        $videos = Video::where('user_id', Auth::id())->get();
        return view('Site.Pages.videos.index', compact('videos'));
    }

    public function publicIndex()
    {
        // busca todos os vídeos já enviados e carrega o usuário dono
        $videos = Video::with('user')->latest()->get();

        return view('Site.Pages.videos.public', compact('videos'));
    }

}
