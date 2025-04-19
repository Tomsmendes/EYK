<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use Illuminate\Http\Request;

class CursoController extends Controller
{
    public function index()
    {
        $data['cursos'] = Curso::all();
        return view('admin.cursos.index', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string',
            'category' => 'required|string',
            'status' => 'required|string',
            'published_at' => 'nullable|date',
            'thumbnail' => 'nullable|mimes:png,jpg,jpeg|max:2048',
            'price' => 'nullable|numeric',
            'duration' => 'nullable|integer'
        ]);

        $filePath = public_path('uploads/cursos');
        $curso = new Curso();
        $curso->description = $request->description;
        $curso->category = $request->category;
        $curso->status = $request->status;
        $curso->published_at = $request->published_at;
        $curso->price = $request->price;
        $curso->duration = $request->duration;

        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $file_name = time() . '_' . $file->getClientOriginalName();
            $file->move($filePath, $file_name);
            $curso->thumbnail = $file_name;
        }

        $curso->save();

        return redirect()->route('cursos.index')->with('success', 'Curso criado com sucesso!');
    }

    public function update(Request $request, Curso $curso)
    {
        $request->validate([
            'description' => 'required|string',
            'category' => 'required|string',
            'status' => 'required|string',
            'published_at' => 'nullable|date',
            'thumbnail' => 'nullable|mimes:png,jpg,jpeg|max:2048',
            'price' => 'nullable|numeric',
            'duration' => 'nullable|integer'
        ]);

        $data = [
            'description' => $request->description,
            'category' => $request->category,
            'status' => $request->status,
            'published_at' => $request->published_at,
            'price' => $request->price,
            'duration' => $request->duration,
        ];

        if ($request->hasFile('thumbnail')) {
            if ($curso->thumbnail && file_exists(public_path('uploads/cursos/' . $curso->thumbnail))) {
                unlink(public_path('uploads/cursos/' . $curso->thumbnail));
            }

            $file = $request->file('thumbnail');
            $file_name = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/cursos'), $file_name);
            $data['thumbnail'] = $file_name;
        }

        $curso->update($data);

        return redirect()->route('cursos.index')->with('success', 'Curso atualizado com sucesso!');
    }

    public function destroy(Curso $curso)
    {
        if ($curso->thumbnail && file_exists(public_path('uploads/cursos/' . $curso->thumbnail))) {
            unlink(public_path('uploads/cursos/' . $curso->thumbnail));
        }

        $curso->delete();

        return redirect()->route('cursos.index')->with('success', 'Curso excluído com sucesso!');
    }
}
