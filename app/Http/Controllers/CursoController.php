<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use Illuminate\Http\Request;

class CursoController extends Controller
{
    public function index()
    {
        $cursos = Curso::all();
        return view('admin.cursos.index', compact('cursos'));
    }

    public function create()
    {
        return view('admin.cursos.create');
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
            $file_name = time() . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $file_name);
            $data['thumbnail'] = $file_name;
        }

        Curso::create($data);

        return redirect()->route('cursos.index')->with('success', 'Curso criado com sucesso!');
    }

   /* public function show(Curso $curso)
    {
        return view('admin.cursos.show', compact('curso'));
    }*/

    public function edit($id)
    {
        $cursos = Curso::where('id',$id)->first();

        return view('admin.cursos.edit', compact('cursos'));
    }

    public function update(Request $request, $id)
    {
        $curso = Curso::findOrFail($id); 
    
        $request->validate([
            'category' => 'required|string',
            'status' => 'required|in:published,draft',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'price' => 'nullable|numeric',
            'duration' => 'nullable|string',
        ]);
    
        $data = [
            'category' => $request->category,
            'status' => $request->status,
            'price' => $request->price,
            'duration' => $request->duration,
        ];
    
        if ($request->hasFile('thumbnail')) {
            if ($curso->thumbnail && file_exists(public_path($curso->thumbnail))) {
                unlink(public_path($curso->thumbnail));
            }
    
            $file = $request->file('thumbnail');
            $file_name = time() . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $file_name);
            $data['thumbnail'] = $file_name;
        }
    
        $curso->update($data);

        return redirect()->route('cursos.index')->with('success', 'Curso atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $curso = Curso::where('id',$id)->first();
        $curso->delete();

        return redirect()->route('cursos.index')->with('success', 'Curso deletado com sucesso!');
    }
}
