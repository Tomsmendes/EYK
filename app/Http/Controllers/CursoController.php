<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use Illuminate\Http\Request;

class CursoController extends Controller
{
    public function index()
    {
        $cursos = Curso::all();
        return view('cursos.index', compact('cursos'));
    }

    public function create()
    {
        return view('cursos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|string',
            'status' => 'required|in:published,draft',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'price' => 'nullable|numeric',
            'duration' => 'nullable|string',
        ]);

        $data = $request->all();

        // Upload de imagem
        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $file_name = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $file_name);
            $data['thumbnail'] = 'uploads/' . $file_name;
        }

        Curso::create($data);

        return redirect()->route('cursos.index')->with('success', 'Curso criado com sucesso!');
    }

    public function show(Curso $curso)
    {
        return view('cursos.show', compact('curso'));
    }

    public function edit(Curso $curso)
    {
        return view('cursos.edit', compact('curso'));
    }

    public function update(Request $request, Curso $curso)
    {
        $request->validate([
            'category' => 'required|string',
            'status' => 'required|in:published,draft',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'price' => 'nullable|numeric',
            'duration' => 'nullable|string',
        ]);

        $data = $request->all();

        // Upload de nova imagem e remoção da antiga
        if ($request->hasFile('thumbnail')) {
            if ($curso->thumbnail && file_exists(public_path($curso->thumbnail))) {
                unlink(public_path($curso->thumbnail));
            }
            $file = $request->file('thumbnail');
            $file_name = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $file_name);
            $data['thumbnail'] = 'uploads/' . $file_name;
        }

        $curso->update($data);

        return redirect()->route('cursos.index')->with('success', 'Curso atualizado com sucesso!');
    }

    public function destroy(Curso $curso)
    {
        if ($curso->thumbnail && file_exists(public_path($curso->thumbnail))) {
            unlink(public_path($curso->thumbnail));
        }

        $curso->delete();

        return redirect()->route('cursos.index')->with('success', 'Curso deletado com sucesso!');
    }
}
