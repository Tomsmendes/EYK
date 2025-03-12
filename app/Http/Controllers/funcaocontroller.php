<?php

namespace App\Http\Controllers;

use App\Models\Funcao;
use Illuminate\Http\Request;

class funcaocontroller extends Controller
{
    public function index()
    {
        $funcoes = Funcao::all();
        return view('admin.funcoes.index', compact('funcoes'));
    }

    public function create()
    {
        return view('admin.funcoes.create');
    }

    public function store(Request $request)
    {
        Funcao::create($request->all());

       return redirect()->route('funcoes.index');
    }


    public function edit(string $id)
    {
        $funcoes = Funcao::where('id',$id)->first();
        
        if(!empty($funcoes))
        {
            return view('admin.funcoes.edit', compact('funcoes'));
        }
        else
        {
            return redirect()->route('funcoes.index');
        }
    }

    public function update(Request $request, string $id)
    {
        $data = [
            'name_fc' => $request->name_fc,
            'descricao' => $request->descricao,
        ];
        Funcao::where('id',$id)->update($data);

        return redirect()->route('funcoes.index');
    }

    function destroy(string $id)
    {
        $funcoes = Funcao::where('id',$id)->first();
        $funcoes->delete();

        return redirect()->route('funcoes.index')->with('success', 'Função excluída com sucesso!');
    }
}
