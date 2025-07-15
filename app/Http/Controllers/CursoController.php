<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\User;
use Illuminate\Http\Request;

class CursoController extends Controller
{
    public function index()
    {
        $data['cursos'] = Curso::join('users', 'cursos.user_id', '=', 'users.id')
            ->select(
                'cursos.*',
                'users.vc_nome as user_name',
            )
            ->get();

        $data['users'] = User::all(); // ou 'funcaos' dependendo da convenção do seu model

        return view('Site.Pages.cursos.index', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
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
        $curso->user_id = $request->user_id;
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
            'user_id' => 'required|exists:users,id',
            'description' => 'required|string',
            'category' => 'required|string',
            'status' => 'required|string',
            'published_at' => 'nullable|date',
            'thumbnail' => 'nullable|mimes:png,jpg,jpeg|max:2048',
            'price' => 'nullable|numeric',
            'duration' => 'nullable|integer'
        ]);

        $data = [
            'user_id' => $request->user_id,
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