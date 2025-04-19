<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Aula;
use Illuminate\Http\Request;

class AulaController extends Controller
{
    public function index()
    {
        $data['aulas'] = Aula::join('cursos', 'aulas.curso_id', '=', 'cursos.id')
            ->select('aulas.*', 'cursos.description as curso_description')
            ->get();

        $data['cursos'] = Curso::all();

        return view('admin.aulas.index', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'required|integer',
            'curso_id' => 'required|exists:cursos,id',
        ]);

        Aula::create($request->all());

        return redirect()->route('aulas.index')->with('success', 'Aula criada com sucesso!');
    }

    public function update(Request $request, Aula $aula)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'required|integer',
        ]);

        $aula->update($request->all());

        return redirect()->route('aulas.index')->with('success', 'Aula atualizada com sucesso!');
    }

    public function destroy(Aula $aula)
    {
        $aula->delete();
        return redirect()->route('aulas.index')->with('success', 'Aula excluída com sucesso!');
    }

    public function indexNonNested()
    {
        return redirect()->route('cursos.index')->with('error', 'Selecione um curso para ver as aulas.');
    }
}
