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

        return view('Site.Pages.aulas.index', $data);
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

        // Redirect back to the course details page with success message
        return redirect()->route('cursos.show', $request->curso_id)
                        ->with('success', 'Aula criada com sucesso!');
    }

    public function update(Request $request, Aula $aula)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'required|integer',
        ]);

        $aula->update($request->all());

        // Optionally redirect to the course details page instead of aulas.index
        return redirect()->route('cursos.show', $aula->curso_id)
                        ->with('success', 'Aula atualizada com sucesso!');
    }

    public function destroy(Aula $aula)
    {
        $curso_id = $aula->curso_id; // Store curso_id before deletion
        $aula->delete();
        
        // Redirect back to the course details page
        return redirect()->route('cursos.show', $curso_id)
                        ->with('success', 'Aula excluída com sucesso!');
    }

    public function indexNonNested()
    {
        return redirect()->route('cursos.index')->with('error', 'Selecione um curso para ver as aulas.');
    }
}