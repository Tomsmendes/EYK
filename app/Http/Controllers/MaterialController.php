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
        $data['materiais'] = Material::join('aulas', 'materials.aula_id', '=', 'aulas.id')->
        select(
            'materials.*',
            'aulas.title as a_nome'
        )->get();

        $data ['aulas'] = Aula::all();

        return view('admin.materiais.index', $data);
    }

    public function store(Request $request, Curso $curso, Aula $aula)
    {
        $request->validate([
            'mt_name' => 'required|string|max:255',
            'mt_descricao' => 'nullable|string',
            'url' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'aula_id' => 'required|exists:aulas,id',
        ]);

        $material = new Material();
        $material->mt_name = $request->mt_name;
        $material->mt_descricao = $request->mt_descricao;
        $material->aula_id = $request->aula_id;

        if ($request->hasFile('url')) {
            $file = $request->file('url');
            $file_name = time() . '_' . $file->getClientOriginalName();
            $material->url = $file->storeAs('materiais', $file_name, 'public');
        }

        $material->save();

        Session::flash('success', 'Material criado com sucesso!');
        return redirect()->route('materiais.index', [$curso, $aula]);
    }

    public function update(Request $request, Curso $curso, Aula $aula, Material $material)
    {
        $request->validate([
            'mt_name' => 'required|string|max:255',
            'mt_descricao' => 'nullable|string',
            'url' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'aula_id' => 'required|exists:aulas,id',
        ]);

        $data = [
            'mt_name' => $request->mt_name,
            'mt_descricao' => $request->mt_descricao,
            'aula_id' => $request->aula_id,
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
        return redirect()->route('materiais.index', [$curso, $aula]);
    }

    public function destroy(Curso $curso, Aula $aula, Material $material)
    {
        if ($material->url && Storage::disk('public')->exists($material->url)) {
            Storage::disk('public')->delete($material->url);
        }
        $material->delete();

        Session::flash('success', 'Material excluído com sucesso!');
        return redirect()->route('materiais.index', [$curso, $aula]);
    }

    
}