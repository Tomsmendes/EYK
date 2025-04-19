<?php

namespace App\Http\Controllers;

use App\Models\Funcao;
use Illuminate\Http\Request;

class FuncaoController extends Controller
{
    public function index()
    {
        $funcoes = Funcao::all();
        return view('admin.funcoes.index', compact('funcoes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_fc' => 'required|string|max:255',
            'descricao' => 'nullable|string',
        ]);

        Funcao::create($validated);

        return redirect()->route('funcoes.index')->with('success', 'Função criada com sucesso!');
    }

    public function update(Request $request, Funcao $funcao)
    {
        $validated = $request->validate([
            'name_fc' => 'required|string|max:255',
            'descricao' => 'nullable|string',
        ]);

        $funcao->update($validated);

        return redirect()->route('funcoes.index')->with('success', 'Função atualizada com sucesso!');
    }

    public function destroy(Funcao $funcao)
    {
        $funcao->delete();
        return redirect()->route('funcoes.index')->with('success', 'Função excluída com sucesso!');
    }
}