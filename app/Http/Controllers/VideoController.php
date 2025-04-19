<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Aula;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class VideoController extends Controller
{
    public function index()
    {
        $data['videos'] = Video::join('aulas', 'videos.aula_id', '=', 'aulas.id')->
        select(
            'videos.*',
            'aulas.title as a_nome'
        )->get();

        $data ['aulas'] = Aula::all();

        return view('admin.videos.index', $data);
    }

    public function store(Request $request, Curso $curso, Aula $aula)
    {
    
        $request->validate([
            'vd_name' => 'required|string|max:255',
            'url' => 'required|url',
            'vd_descricao' => 'nullable|string',
            'aula_id' => 'required',
        ]);

        $video = new Video();
        $video->vd_name = $request->vd_name;
        $video->url = $request->url;
        $video->vd_descricao = $request->vd_descricao;
        $video->aula_id = $request->aula_id;
        $video->save();

        Session::flash('success', 'Vídeo criado com sucesso!');
        return redirect()->route('videos.index', [$curso, $aula]);
    }

    public function update(Request $request, Curso $curso, Aula $aula, Video $video)
    {
        $request->validate([
            'vd_name' => 'required|string|max:255',
            'url' => 'required|url',
            'vd_descricao' => 'nullable|string',
            'aula_id' => 'required|exists:aulas,id',
        ]);

        $video->update([
            'vd_name' => $request->vd_name,
            'url' => $request->url,
            'vd_descricao' => $request->vd_descricao,
            'aula_id' => $request->aula_id,
        ]);

        Session::flash('success', 'Vídeo atualizado com sucesso!');
        return redirect()->route('videos.index', [$curso, $aula]);
    }

    public function destroy(Curso $curso, Aula $aula, Video $video)
    {
        $video->delete();
        Session::flash('success', 'Vídeo excluído com sucesso!');
        return redirect()->route('videos.index', [$curso, $aula]);
    }

    public function indexNonNested()
    {
        Session::flash('error', 'Selecione um curso e uma aula para ver os vídeos.');
        return redirect()->route('cursos.index');
    }
}