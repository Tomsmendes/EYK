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

        return view('Site.Pages.videos.index', $data);
    }

    public function store(Request $request, Curso $curso, Aula $aula)
    {
        try {
            $request->validate([
                'vd_name' => 'required|string|max:255',
                'file_path' => 'required|file|mimes:mp4,avi,mkv|max:102400',
                'vd_descricao' => 'nullable|string',
                'aula_id' => 'required',
            ]);

            $videoData = $request->except('file_path');

            if ($request->hasFile('file_path')){
                $file = $request->file('file_path');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/videos/'), $fileName);
                $videoData['file_path'] = 'uploads/videos/' . $fileName;
            }

            $video = Video::create($videoData);

            Session::flash('success', 'Vídeo criado com sucesso!');
            return redirect()->route('videos.index', [$curso, $aula]);
        }
        catch (\Exception $e) {
            return back()->withErrors(['error' => 'Erro ao criar usuário: ' . $e->getMessage()])->withInput();
        }
    }

    public function update(Request $request, Curso $curso, Aula $aula, Video $video)
    {
        $request->validate([
            'vd_name' => 'required|string|max:255',
            'vd_descricao' => 'nullable|string',
            'aula_id' => 'required|exists:aulas,id',
            'file_path' => 'nullable|file|mimes:mp4,avi,mkv|max:102400', // Novo arquivo é opcional
        ]);

        $videoData = $request->except('file_path');

        if ($request->hasFile('file_path')) {
            if ($video->file_path && file_exists(public_path($video->file_path))) {
                unlink(public_path($video->file_path));
            }

            $file = $request->file('file_path');
            $fileName = uniqid('video_') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/videos/'), $fileName);
            $videoData['file_path'] = 'uploads/videos/' . $fileName;
        }

        $video->update($videoData);

        Session::flash('success', 'Vídeo atualizado com sucesso!');
        return redirect()->route('videos.index', [$curso, $aula]);
    }

    public function destroy(Curso $curso, Aula $aula, Video $video)
    {
        if ($video->file_path && file_exists(public_path($video->file_path))) {
            unlink(public_path($video->file_path));
        }

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