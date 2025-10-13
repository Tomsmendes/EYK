<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Aula;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class MaterialController extends Controller
{
    public function index()
    {
        $data['materiais'] = Material::with('aula.curso')->get();
        return view('Site.tipo.prof.materiais.index', $data);
    }

    // Listar materiais de uma aula específica
    public function indexByAula(Curso $curso, Aula $aula)
    {
        $data['materiais'] = $aula->materiais;
        $data['curso'] = $curso;
        $data['aula'] = $aula;
        
        return view('Site.tipo.prof.materiais.index', $data);
    }

    // Mostrar formulário de criação de material (ANINHADO)
    public function create(Curso $curso, Aula $aula)
    {
        return view('Site.tipo.prof.materiais.create', compact('curso', 'aula'));
    }

    // Mostrar detalhes de um material específico (ANINHADO)
    public function show(Curso $curso, Aula $aula, Material $material)
    {
        $material->load('aula.curso');
        
        return view('Site.tipo.prof.materiais.show', compact('curso', 'aula', 'material'));
    }

    // Método para download (ANINHADO)
    public function download(Curso $curso, Aula $aula, Material $material)
    {
        // Verificar se o arquivo existe
        if (!$material->url) {
            Session::flash('error', 'Arquivo não encontrado.');
            return back();
        }

        // Verificar se o arquivo existe no storage
        if (!Storage::disk('public')->exists($material->url)) {
            Session::flash('error', 'Arquivo não encontrado no servidor.');
            return back();
        }

        // Fazer download
        return Storage::disk('public')->download($material->url);
    }

    // Store para materiais aninhados
    public function store(Request $request, Curso $curso = null, Aula $aula = null)
    {
        $request->validate([
            'mt_name' => 'required|string|max:255',
            'mt_descricao' => 'nullable|string',
            'url' => 'required|file|mimes:pdf,doc,docx,ppt,pptx,txt,zip,rar|max:2048',
            'aula_id' => 'required|exists:aulas,id',
        ]);

        // Se aula não foi passada via rota, usa do request
        if (!$aula) {
            $aula = Aula::findOrFail($request->aula_id);
        }

        $material = new Material();
        $material->mt_name = $request->mt_name;
        $material->mt_descricao = $request->mt_descricao;
        $material->aula_id = $aula->id;

        if ($request->hasFile('url')) {
            $file = $request->file('url');
            $file_name = time() . '_' . $file->getClientOriginalName();
            $material->url = $file->storeAs('materiais', $file_name, 'public');
        }

        $material->save();

        // Se é uma rota aninhada, redireciona para a rota aninhada
        if ($curso && $aula) {
            Session::flash('success', 'Material criado com sucesso!');
            return redirect()->route('cursos.aulas.materiais.show', [
                'curso' => $curso->id, 
                'aula' => $aula->id, 
                'material' => $material->id
            ]);
        }

        // Se não, redireciona para rota independente
        Session::flash('success', 'Material criado com sucesso!');
        return redirect()->route('materiais.show', $material->id);
    }

    public function edit(Curso $curso, Aula $aula, Material $material)
    {
        return view('Site.tipo.prof.materiais.edit', compact('curso', 'aula', 'material'));
    }

    public function update(Request $request, Curso $curso, Aula $aula, Material $material)
    {
        $request->validate([
            'mt_name' => 'required|string|max:255',
            'mt_descricao' => 'nullable|string',
            'url' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,txt,zip,rar|max:2048',
        ]);

        $data = [
            'mt_name' => $request->mt_name,
            'mt_descricao' => $request->mt_descricao,
        ];

        if ($request->hasFile('url')) {
            if ($material->url) {
                Storage::disk('public')->delete($material->url);
            }
            $file = $request->file('url');
            $file_name = time() . '_' . $file->getClientOriginalName();
            $data['url'] = $file->storeAs('materiais', $file_name, 'public');
        }

        $material->update($data);

        Session::flash('success', 'Material atualizado com sucesso!');
        return redirect()->route('cursos.aulas.materiais.show', [
            'curso' => $curso->id, 
            'aula' => $aula->id, 
            'material' => $material->id
        ]);
    }

    public function destroy(Curso $curso, Aula $aula, Material $material)
    {
        if ($material->url && Storage::disk('public')->exists($material->url)) {
            Storage::disk('public')->delete($material->url);
        }
        $material->delete();

        Session::flash('success', 'Material excluído com sucesso!');
        return redirect()->route('cursos.aulas.materiais.index', [
            'curso' => $curso->id, 
            'aula' => $aula->id
        ]);
    }
}