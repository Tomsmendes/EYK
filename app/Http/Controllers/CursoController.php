<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CursoController extends Controller
{
    public function index(Request $request)
    {
        // Captura o termo de pesquisa
        $search = $request->input('search');

        // Consulta com join + pesquisa
        $data['cursos'] = Curso::join('users', 'cursos.user_id', '=', 'users.id')
            ->select('cursos.*', 'users.vc_nome as user_name')
            ->when($search, function ($query, $search) {
                $query->where('cursos.name_curso', 'like', "%{$search}%")
                    ->orWhere('cursos.category', 'like', "%{$search}%")
                    ->orWhere('users.vc_nome', 'like', "%{$search}%");
            })
            ->orderBy('cursos.created_at', 'desc')
            ->get();

        $data['users'] = User::all();
        $data['search'] = $search; // envia o termo para a view

        // Verifica se o usuário é aluno
        if (Auth::check() && Auth::user()->vc_tipo === 'aluno') {
            return view('Site.tipo.aluno.cursos.index', $data);
        }

        return view('Site.tipo.prof.cursos.index', $data);
    }

    public function show(Curso $curso)
    {
        $data['curso'] = Curso::join('users', 'cursos.user_id', '=', 'users.id')
            ->select('cursos.*', 'users.vc_nome as user_name')
            ->where('cursos.id', $curso->id)
            ->firstOrFail();

        // Verifica se o usuário é aluno
        if (Auth::check() && Auth::user()->vc_tipo === 'aluno') {
            return view('Site.tipo.aluno.cursos.show', $data);
        }

        return view('Site.tipo.prof.cursos.show', $data);
    }

    public function create()
    {
        // Se for aluno, redireciona para a página de cursos (index)
        if (Auth::check() && Auth::user()->tipo === 'aluno') {
            return redirect()->route('cursos.index')->with('error', 'Acesso não permitido.');
        }

        $data['users'] = User::all();
        return view('Site.tipo.prof.cursos.create', $data);
    }

    public function edit(Curso $curso)
    {
        // Se for aluno, redireciona para a página de cursos (index)
        if (Auth::check() && Auth::user()->tipo === 'aluno') {
            return redirect()->route('cursos.index')->with('error', 'Acesso não permitido.');
        }

        $data['users'] = User::all();
        $data['curso'] = $curso;
        
        return view('Site.tipo.prof.cursos.edit', $data);
    }

    public function store(Request $request)
    {
        // Se for aluno, redireciona para a página de cursos (index)
        if (Auth::check() && Auth::user()->tipo === 'aluno') {
            return redirect()->route('cursos.index')->with('error', 'Acesso não permitido.');
        }

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'name_curso' => 'required|string',
            'description' => 'required|string',
            'category' => 'required|string',
            'status' => 'required|string',
            'thumbnail' => 'nullable|mimes:png,jpg,jpeg|max:2048',
        ]);

        $curso = new Curso();
        $curso->user_id = $request->user_id;
        $curso->name_curso = $request->name_curso;
        $curso->description = $request->description;
        $curso->category = $request->category;
        $curso->status = $request->status;

        if ($request->hasFile('thumbnail')) {
            $filePath = public_path('uploads/cursos');
            if (!file_exists($filePath)) {
                mkdir($filePath, 0755, true);
            }

            $file = $request->file('thumbnail');
            $file_name = time() . '_' . $file->getClientOriginalName();
            $file->move($filePath, $file_name);
            $curso->thumbnail = $file_name;
        }

        $curso->save();

        // ✅ Redireciona diretamente para a página do curso criado
        return redirect()->route('cursos.show', $curso->id)->with('success', 'Curso criado com sucesso!');
    }

    public function update(Request $request, Curso $curso)
    {
        // Se for aluno, redireciona para a página de cursos (index)
        if (Auth::check() && Auth::user()->tipo === 'aluno') {
            return redirect()->route('cursos.index')->with('error', 'Acesso não permitido.');
        }

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'name_curso' => 'required|string',
            'description' => 'required|string',
            'category' => 'required|string',
            'status' => 'required|string',
            'thumbnail' => 'nullable|mimes:png,jpg,jpeg|max:2048',
        ]);

        $data = [
            'user_id' => $request->user_id,
            'name_curso' => $request->name_curso,
            'description' => $request->description,
            'category' => $request->category,
            'status' => $request->status,
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
        // Se for aluno, redireciona para a página de cursos (index)
        if (Auth::check() && Auth::user()->tipo === 'aluno') {
            return redirect()->route('cursos.index')->with('error', 'Acesso não permitido.');
        }

        if ($curso->thumbnail && file_exists(public_path('uploads/cursos/' . $curso->thumbnail))) {
            unlink(public_path('uploads/cursos/' . $curso->thumbnail));
        }

        $curso->delete();

        return redirect()->route('cursos.index')->with('success', 'Curso excluído com sucesso!');
    }
}