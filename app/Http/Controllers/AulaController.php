<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Aula;
use Illuminate\Http\Request;

class AulaController extends Controller
{
    public function index()
    {
        $data['aulas'] = Aula::with('curso')->get();
        return view('Site.tipo.prof.aulas.index', $data);
    }

    public function indexByCurso(Curso $curso)
    {
        $data['aulas'] = $curso->aulas()->with('curso')->get();
        $data['curso'] = $curso->load('user');

        return view('Site.tipo.prof.cursos.show', $data);
    }

    // CORREÇÃO: Receber curso como parâmetro
    public function create(Curso $curso)
    {
        return view('Site.tipo.prof.aulas.create', compact('curso'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'curso_id' => 'required|exists:cursos,id',
        ]);

        Aula::create($request->all());

        return redirect()->route('cursos.show', $request->curso_id)
                        ->with('success', 'Aula criada com sucesso!');
    }

    public function show(Aula $aula)
    {
        $aula->load('curso', 'videos', 'materiais');
        return view('Site.tipo.prof.aulas.show', compact('aula'));
    }

    public function edit(Aula $aula)
    {
        $aula->load('curso');
        return view('Site.tipo.prof.aulas.edit', compact('aula'));
    }

    public function update(Request $request, Aula $aula)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $aula->update($request->all());

        return redirect()->route('cursos.show', $aula->curso_id)
                        ->with('success', 'Aula atualizada com sucesso!');
    }

    public function destroy(Aula $aula)
    {
        $curso_id = $aula->curso_id;
        $aula->delete();
        
        return redirect()->route('cursos.show', $curso_id)
                        ->with('success', 'Aula excluída com sucesso!');
    }

    public function indexNonNested()
    {
        return redirect()->route('cursos.index')->with('error', 'Selecione um curso para ver as aulas.');
    }
}