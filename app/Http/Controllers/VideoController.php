<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;
use Illuminate\Support\Facades\Auth;
use App\Models\Aula;
use Illuminate\Support\Facades\Storage;
use FFMpeg\FFMpeg;  // Só se FFmpeg instalado; senão, comente

class VideoController extends Controller
{
    public function create(Request $request)
    {

        $aulas = Aula::all();
        $aulaId = $request->query('aula_id'); // Captura o ID passado pela URL
        return view('Site.tipo.prof.videos.create', compact('aulas', 'aulaId'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'titulo' => 'required|string|max:255',
            'video' => 'required|mimes:mp4,webm|max:512000',  // 500MB
            'thumbnail' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'aula_id' => 'nullable|exists:aulas,id',
        ]);

        // Upload vídeo
        $videoPath = $request->file('video')->store('videos', 'public');
        $thumbPath = null;

        // Thumbnail manual se enviado
        if ($request->hasFile('thumbnail')) {
            $thumbPath = $request->file('thumbnail')->store('thumbnails', 'public');
        } else {
            // Auto thumbnail com FFmpeg (opcional, grátis)
            try {
                $ffmpeg = FFMpeg::create();
                $video = $ffmpeg->open(storage_path('app/public/' . $videoPath));
                $thumbPath = $video->frame(FFMpeg\Coordinate\TimeCode::fromSeconds(1))->save(storage_path('app/public/thumbnails/thumb_' . time() . '.jpg'));
                $thumbPath = str_replace(storage_path('app/public/'), '', $thumbPath);
            } catch (\Exception $e) {
                // Se FFmpeg falhar, pula
                \Log::warning('Thumbnail auto falhou: ' . $e->getMessage());
            }
        }

        $video = Video::create([
            'titulo' => $request->titulo,
            'descricao' => $request->descricao ?? '',
            'caminho_video' => $videoPath,
            'caminho_thumbnail' => $thumbPath,
            'user_id' => Auth::id(),
            'aula_id' => $request->filled('aula_id') ? $request->aula_id : null,
            'upload_status' => 'completed',
        ]);

        return redirect()->route('videos.index')->with('success', 'Vídeo enviado! Thumbnail gerado.');
    }

    public function index()
    {
        // Se for aluno, redireciona para a view pública
        if (Auth::check() && Auth::user()->vc_tipo === 'aluno') {
            return $this->publicIndex();
        }

        // Professor vê apenas seus vídeos
        $videos = Video::where('user_id', Auth::id())->latest()->get();
        return view('Site.tipo.prof.videos.index', compact('videos'));
    }

    public function publicIndex()
    {
        $videos = Video::with('user')->latest()->get();
        
        // Verifica se é aluno para usar view específica
        if (Auth::check() && Auth::user()->vc_tipo === 'aluno') {
            return view('Site.tipo.aluno.videos.index', compact('videos'));
        }

        return view('Site.tipo.prof.videos.public', compact('videos'));
    }

    public function show(Video $video)
    {
        // Aluno pode ver qualquer vídeo (se estiver logado)
        if (Auth::check() && Auth::user()->vc_tipo === 'aluno') {
            return view('Site.tipo.aluno.videos.show', compact('video'));
        }

        // Professor só pode ver seus próprios vídeos
        if ($video->user_id !== Auth::id()) {
            abort(403, 'Acesso negado.');
        }

        return view('Site.tipo.prof.videos.show', compact('video'));
    }

    public function destroy(Video $video)
    {
        // Se for aluno, redireciona
        if (Auth::check() && Auth::user()->tipo === 'aluno') {
            return redirect()->route('videos.index')->with('error', 'Acesso não permitido.');
        }

        // Permitir apenas o dono do vídeo excluir
        if ($video->user_id !== Auth::id()) {
            abort(403, 'Acesso negado.');
        }

        // Excluir arquivos físicos (vídeo + thumbnail)
        if ($video->caminho_video && Storage::disk('public')->exists($video->caminho_video)) {
            Storage::disk('public')->delete($video->caminho_video);
        }

        if ($video->caminho_thumbnail && Storage::disk('public')->exists($video->caminho_thumbnail)) {
            Storage::disk('public')->delete($video->caminho_thumbnail);
        }

        // Excluir registro do banco
        $video->delete();

        return redirect()->back()->with('success', '🎬 Vídeo excluído com sucesso!');
    }

    // Método específico para alunos assistirem vídeos
    public function assistir(Video $video)
    {
        // Verifica se o usuário é aluno
        if (!Auth::check() || Auth::user()->tipo !== 'aluno') {
            abort(403, 'Acesso permitido apenas para alunos.');
        }

        // Verifica se o vídeo pertence a um curso que o aluno está matriculado
        // (Adicione sua lógica de matrícula aqui se necessário)
        
        return view('Site.tipo.aluno.videos.assistir', compact('video'));
    }
}